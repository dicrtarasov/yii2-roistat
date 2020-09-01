<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 01.09.20 20:38:31
 */

declare(strict_types = 1);
namespace dicr\roistat\client;

use dicr\helper\JsonEntity;
use dicr\roistat\RoistatModule;
use dicr\validate\ValidateException;
use Yii;
use yii\base\Exception;
use yii\base\InvalidConfigException;
use yii\httpclient\Client;

use function strtolower;

/**
 * Абстрактный запрос от сайта к Roistat.
 *
 * @property-read RoistatModule $module
 */
abstract class RoistatRequest extends JsonEntity
{
    /** @var RoistatModule */
    protected $_module;

    /**
     * RoistatRequest constructor.
     *
     * @param RoistatModule $module
     * @param array $config
     */
    public function __construct(RoistatModule $module, $config = [])
    {
        $this->_module = $module;

        parent::__construct($config);
    }

    /**
     * @inheritDoc
     */
    public function attributeFields() : array
    {
        // не переопределяем названия полей
        return [];
    }

    /**
     * Модуль.
     *
     * @return RoistatModule
     */
    public function getModule() : RoistatModule
    {
        return $this->_module;
    }

    /**
     * Относительный (название функции) или абсолютный URL запроса.
     *
     * @return string
     */
    abstract public function url() : string;

    /**
     * HTTP-метод
     *
     * @return string
     * @noinspection PhpMethodMayBeStaticInspection
     */
    public function method() : string
    {
        return 'get';
    }

    /**
     * Отправка запроса.
     *
     * @return RoistatResponse (переопределяется в наследнике)
     * @throws Exception
     */
    public function send()
    {
        if (! $this->validate()) {
            throw new ValidateException($this);
        }

        $request = $this->_module->httpClient->createRequest()
            ->setMethod($this->method())
            ->setHeaders([
                'Accept' => 'application/json',
                'Accept-Charset' => 'UTF-8'
            ]);

        // проверяем наличие apiKey для осуществления запросов к Roistat
        if (empty($this->module->clientKey)) {
            throw new InvalidConfigException('для запросов к Roistat необходимо указать clientKey');
        }

        $json = ['key' => $this->_module->clientKey] + $this->json;

        if (strtolower($this->method()) === 'get') {
            $request->setUrl([$this->url()] + $json);
        } else {
            $request->setUrl($this->url())
                ->setData($json)
                ->setFormat(Client::FORMAT_JSON);
        }

        Yii::debug('Запрос: ' . $request->toString(), __METHOD__);
        $response = $request->send();
        Yii::debug('Ответ: ' . $response->toString(), __METHOD__);

        if (! $response->isOk) {
            throw new Exception('Ошибка запроса: ' . $response->toString());
        }

        $response->format = Client::FORMAT_JSON;

        $rr = new RoistatResponse([
            'json' => $response->data
        ]);

        if ($rr->status !== RoistatResponse::STATUS_SUCCESS) {
            throw new Exception('Ошибка запроса: ' . $rr->error);
        }

        return $rr;
    }
}
