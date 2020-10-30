<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 30.10.20 21:12:30
 */

declare(strict_types = 1);
namespace dicr\roistat\callback;

use dicr\roistat\RoistatModule;
use dicr\validate\ValidateException;
use Throwable;
use Yii;
use yii\base\Exception;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\Response;
use yii\web\ServerErrorHttpException;
use yii\web\UnauthorizedHttpException;

use function call_user_func;
use function gettype;
use function md5;

/**
 * Контроллер обработки запросов от Roistat.
 *
 * @property-read RoistatModule $module
 */
class WebhookController extends Controller
{
    /** @var string[] карта запросов */
    public const ACTION_MAP = [
        'import_scheme' => SchemeCallbackRequest::class,
        'export' => ExportCallbackRequest::class,
        'export_clients' => ClientsCallbackRequest::class,
        'lead' => LeadCallbackRequest::class,
        'message' => MessageCallbackRequest::class,
        'task' => TaskCallbackRequest::class,
        'call' => CallCallbackRequest::class,
    ];

    /**
     * Обработка запроса от Roistat.
     *
     * @param string $action
     * @param string $user
     * @param string $token
     * @return Response
     * @throws Throwable
     */
    public function actionIndex(string $action, string $user, string $token) : Response
    {
        try {
            // проверяем авторизацию
            $this->checkAuth($user, $token);
            $response = $this->handleAction($action);

            return $this->asJson($response ?: '');
        } catch (Throwable $ex) {
            Yii::error($ex, __METHOD__);
            throw $ex;
        }
    }

    /**
     * Проверка авторизации.
     *
     * @param string $user
     * @param string $token
     * @throws UnauthorizedHttpException
     */
    private function checkAuth(string $user, string $token) : void
    {
        if (! empty($this->module->callbackUser)) {
            if ($user !== $this->module->callbackUser) {
                Yii::error('Некорректный пользователь: ' . $user, __METHOD__);
                throw new UnauthorizedHttpException('invalid user: ' . $user);
            }

            if (! empty($this->module->callbackPassword) &&
                $token !== md5($this->module->callbackUser . $this->module->callbackPassword)) {
                Yii::error('Некорректный токен: ' . $token, __METHOD__);
                throw new UnauthorizedHttpException('invalid token: ' . $token);
            }
        }
    }

    /**
     * Обработка запроса.
     *
     * @param string $action
     * @return ?CallbackResponse
     * @throws Exception
     */
    protected function handleAction(string $action) : ?CallbackResponse
    {
        // создаем запрос
        $requestClass = self::ACTION_MAP[$action] ?? null;
        if (empty($requestClass)) {
            throw new BadRequestHttpException('Неизвестное значение action=' . $action);
        }

        /** @var CallbackRequest $request */
        $request = Yii::createObject(['class' => $requestClass], [$this->module]);

        // загружаем запрос
        $request->setJson(Yii::$app->request->queryParams + Yii::$app->request->bodyParams);
        Yii::debug('Callback-запрос: ' . $request->json, __METHOD__);

        // проверяем запрос
        if (! $request->validate()) {
            throw new BadRequestHttpException('', 0, new ValidateException($request));
        }

        /** @var ?CallbackResponse $response */
        $response = ! empty($this->module->callbackHandler) ?
            call_user_func($this->module->callbackHandler, $request) : null;

        // проверяем ответ
        if ($response !== null && (! $response instanceof CallCallbackResponse)) {
            throw new ServerErrorHttpException('Некорректный ответ: ' . gettype($response));
        }

        if (! $response->validate()) {
            throw new ServerErrorHttpException('', 0, new ValidateException($response));
        }

        Yii::debug('Ответ: ' . ($response->json ?? '<пустой>'), __METHOD__);

        return $response;
    }
}
