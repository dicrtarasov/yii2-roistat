<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 01.09.20 20:06:32
 */

declare(strict_types = 1);
namespace dicr\roistat\client;

use dicr\http\UrlInfo;
use dicr\roistat\RoistatModule;
use dicr\validate\PhoneValidator;

use function is_array;

/**
 * Запрос на создание лида в Roistat.
 *
 * Нормально лиды загружаются из roistat в CRM. Однако в прокси-варианте лиды создает в Roistat сайт (CMS),
 * а затем Roistat отправляет лиды в CRM Webhook.
 *
 * Если сделка создана успешно, скрипт вернет ее ID. Например, это можно использовать, чтобы после создания
 * заявки сразу показывать клиенту номер заказа (обычно совпадает с ID сделки в CRM).
 * Если сделку не удалось создать, вместо ID сделки будет ошибка.
 *
 * @link https://help.roistat.com/quick-start/Zagruzka_zajavok_v_Roistat
 * @link https://help.roistat.com/integrations/CRM_i_CMS/Dopolnitel%E2%80%99nye_nastroiki_integracii/Peredacha_zajavok_v_CRM_cherez_Roistat_(proksilid)
 */
class ProxyLeadAddRequest extends RoistatRequest
{
    /** @var string значение куки roistat_visit */
    public $roistat;

    /** @var string Название сделки */
    public $title;

    /** @var string Комментарий к сделке */
    public $comment;

    /** @var string ФИО клиента */
    public $name;

    /** @var string email клиента */
    public $email;

    /** @var string номер телефона */
    public $phone;

    /**
     * @var ?string Способ создания сделки (необязательный параметр).
     * Укажите то значение, которое затем должно отображаться в аналитике в группировке "Способ создания заявки".
     */
    public $orderCreationMethod;

    /**
     * @var ?bool
     * После создания в Roistat заявки, Roistat инициирует обратный звонок на номер клиента,
     * если значение параметра равно 1 и в Ловце лидов включен индикатор обратного звонка.
     */
    public $isNeedCallback;

    /**
     * @var ?string
     * Переопределяет номер, указанный в настройках обратного звонка.
     */
    public $callbackPhone;

    /**
     * @var ?bool (default 0)
     * Используйте параметр 'sync' => '1', когда после отправки заявки с сайта в Roistat
     * требуется получать от CRM подтверждение создания сделки.
     */
    public $sync;

    /** @var ?bool Включение проверки заявок на дубли (default 1) */
    public $isNeedCheckOrderInProcessing;

    /**
     * @var ?bool
     * Если создана дублирующая заявка, в нее будет добавлен комментарий об этом (default 1)
     */
    public $isNeedCheckOrderInProcessingAppend;

    /** @var ?bool Не отправлять заявку в CRM */
    public $isSkipSending;

    /**
     * @var ?array
     * Массив дополнительных полей. Если дополнительные поля не нужны, оставьте массив пустым.
     * Помимо массива fields, который используется для сделки, есть еще массив client_fields,
     * который используется для установки полей контакта.
     */
    public $fields;

    /**
     * @var ?string кодировка данных (бред - UTF-8, Windows-1251)
     * Сервер преобразует значения полей из указанной кодировки в UTF-8.
     */
    public $charset;

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            ['roistat', 'trim'],
            ['roistat', 'default', 'value' => RoistatModule::clientVisit()],
            ['roistat', 'required'],

            [['title', 'comment', 'name'], 'trim'],
            [['title', 'comment', 'name'], 'required'],

            ['email', 'trim'],
            ['email', 'default'],
            ['email', 'email'],

            ['phone', PhoneValidator::class],
            ['phone', 'required'],
            ['phone', 'filter', 'filter' => static function (int $phone) {
                return PhoneValidator::format($phone);
            }],

            ['orderCreationMethod', 'default'],

            ['isNeedCallback', 'default'],
            ['isNeedCallback', 'boolean'],
            ['isNeedCallback', 'filter', 'filter' => 'intval', 'skipOnEmpty' => true],

            ['callbackPhone', 'trim'],
            ['callbackPhone', 'default'],

            [['sync', 'isNeedCheckOrderInProcessing', 'isNeedCheckOrderInProcessingAppend', 'isSkipSending'],
             'default'],
            [['sync', 'isNeedCheckOrderInProcessing', 'isNeedCheckOrderInProcessingAppend', 'isSkipSending'],
             'boolean'],
            [['sync', 'isNeedCheckOrderInProcessing', 'isNeedCheckOrderInProcessingAppend', 'isSkipSending'], 'filter',
             'filter' => 'intval', 'skipOnEmpty' => true],

            ['fields', 'default', 'value' => []],
            ['fields', function (string $attribute) {
                if (! is_array($this->fields)) {
                    $this->addError($attribute, 'fields должны быть массивом');
                }
            }],

            ['charset', 'trim'],
            ['charset', 'default']
        ];
    }

    /**
     * @inheritDoc
     */
    public function url() : string
    {
        // адрес запроса GET https://cloud.roistat.com/api/proxy/1.0/leads/add
        // отличается "api/proxy/1.0" от базового "api/v1"
        // поэтому строим и возвращаем абсолютный URL

        return (new UrlInfo($this->_module->url))
            ->setPath('/api/proxy/1.0/leads/add')
            ->toString();
    }
}
