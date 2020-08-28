<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 29.08.20 03:22:06
 */

declare(strict_types = 1);
namespace dicr\roistat;

use dicr\roistat\request\ProxyLeadAddRequest;
use dicr\roistat\request\ProxyLeadCommentRequest;
use Yii;
use yii\base\InvalidConfigException;
use yii\base\Module;
use yii\httpclient\Client;

use function array_merge;

/**
 * Модуль API Roistat.
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

    /** @var string ключ API */
    public $key;

    /** @var array */
    public $httpClientConfig = [];

    /** @inheritDoc */
    public $controllerNamespace = __NAMESPACE__;

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

        if (empty($this->key)) {
            throw new InvalidConfigException('key');
        }
    }

    /**
     * Клиент HTTP
     *
     * @return Client
     * @throws InvalidConfigException
     */
    public function getHttpClient(): Client
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return Yii::createObject(array_merge([
            'class' => Client::class,
            'baseUrl' => $this->url,
        ], $this->httpClientConfig));
    }

    /**
     * Создает запрос.
     *
     * @param array $config
     * @return RoistatRequest
     * @throws InvalidConfigException
     */
    public function createRequest(array $config): RoistatRequest
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return Yii::createObject($config, [$this]);
    }

    /**
     * Запрос на создание лида.
     *
     * @param array $config
     * @return ProxyLeadAddRequest
     * @throws InvalidConfigException
     */
    public function createProxyLeadAddRequest(array $config): ProxyLeadAddRequest
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->createRequest(array_merge([
            'class' => ProxyLeadAddRequest::class
        ], $config));
    }

    /**
     * Запрос на добавление комментарию лиду.
     *
     * @param array $config
     * @return ProxyLeadCommentRequest
     * @throws InvalidConfigException
     */
    public function createProxyLeadCommentRequest(array $config): ProxyLeadCommentRequest
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->createRequest(array_merge([
            'class' => ProxyLeadCommentRequest::class
        ], $config));
    }

    /**
     * Возвращает номер визита roistat_visit клиента
     *
     * @return string
     */
    public static function clientVisit(): string
    {
        return $_COOKIE['roistat_visit'] ?? '';
    }
}
