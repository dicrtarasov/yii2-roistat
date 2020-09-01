<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 01.09.20 17:35:01
 */

declare(strict_types = 1);
namespace dicr\roistat;

use dicr\roistat\client\ProxyLeadAddRequest;
use dicr\roistat\client\ProxyLeadCommentRequest;
use dicr\roistat\client\RoistatRequest;
use dicr\roistat\client\RoistatResponse;
use Yii;
use yii\base\Exception;
use yii\base\InvalidConfigException;
use yii\base\Module;
use yii\httpclient\Client;

use function array_merge;

/**
 * Модуль API Roistat.
 *
 * Для запросов к Roistat необходимо указать ключ API `clientKey`.
 *
 * Для авторизации запросов от Roistat можно указать callbackUser и callbackPassword.
 * Обработчик запросов можно указать в `callbackHandler`.
 * Webhook URL: `/<module (roistat)>/webhook`
 *
 * @property-read Client $httpClient
 *
 * @link https://help.roistat.com/
 * @link https://roistat.api-docs.io/
 */
class RoistatModule extends Module
{
    /** @var string URL API */
    public const API_URL = 'https://cloud.roistat.com/api/v1';

    /** @var string резервный API URL */
    public const API_URL_RESERVED = 'http://cloud-reserved.roistat.com/api/v1';

    /** @var string API URL */
    public $url = self::API_URL;

    /** @var ?string ключ API клиента Roistat для запросов от CRM к Roistat */
    public $clientKey;

    /** @var ?array */
    public $httpClientConfig = [];

    /** @var ?string логин в CRM для авторизации callback-запросов от Roistat к CRM */
    public $callbackUser;

    /** @var ?string пароль в CRM для авторизации callback-запросов от Roistat к CRM */
    public $callbackPassword;

    /** @var ?callable function(CallbackRequest $request): ?CallbackResponse */
    public $callbackHandler;

    /** @inheritDoc */
    public $controllerNamespace = __NAMESPACE__ . '\\callback';

    /**
     * @inheritDoc
     * @throws InvalidConfigException
     */
    public function init()
    {
        parent::init();

        if (empty($this->url)) {
            throw new InvalidConfigException('url');
        }
    }

    /**
     * Клиент HTTP
     *
     * @return Client
     * @throws InvalidConfigException
     */
    public function getHttpClient() : Client
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return Yii::createObject(array_merge([
            'class' => Client::class,
            'baseUrl' => $this->url,
        ], $this->httpClientConfig ?: []));
    }

    /**
     * Возвращает номер визита roistat_visit клиента
     *
     * @return string
     */
    public static function clientVisit() : string
    {
        return $_COOKIE['roistat_visit'] ?? '';
    }

    /**
     * Создает запрос.
     *
     * @param array $config
     * @return RoistatRequest
     * @throws InvalidConfigException
     */
    public function createRequest(array $config) : RoistatRequest
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return Yii::createObject($config, [$this]);
    }

    /**
     * Запрос на создание прокси-лида (который затем из Roistat передается в CRM).
     *
     * @param array $config конфигурация ProxyLeadAddRequest
     * @return RoistatResponse
     * @throws Exception
     */
    public function addProxyLead(array $config) : RoistatResponse
    {
        $request = $this->createRequest(array_merge([
            'class' => ProxyLeadAddRequest::class
        ], $config));

        return $request->send();
    }

    /**
     * Запрос на добавление комментарию прокси-лиду.
     *
     * @param array $config конфиг ProxyLeadCommentRequest
     * @return RoistatResponse
     * @throws Exception
     */
    public function commentProxyLead(array $config) : RoistatResponse
    {
        $request = $this->createRequest(array_merge([
            'class' => ProxyLeadCommentRequest::class
        ], $config));

        return $request->send();
    }
}
