<?php
/*
 * @copyright 2019-2021 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 22.01.21 16:47:33
 */

declare(strict_types = 1);
namespace dicr\roistat\callback;

use function array_merge;

/**
 * Webhook в Ловце лидов -- это механизм отправки стороннему приложению информации о пользователях,
 * оставляющих заявки через форму Ловца лидов.
 *
 * Тело POST-запроса содержит JSON-объект, отображающий информацию о пользователе, оставившего заявку.
 *
 * @link https://help.roistat.com/features/Lovec_lidov/Otpravka_poimannih_lidov_s_pomoshiu_webhook/
 */
class LeadHunterCallbackRequest extends CallbackRequest
{
    /** @var string уникальный номер письма в Roistat ("111") */
    public $id;

    /** @var string номер визита ("123456") */
    public $visitId;

    /** @var string имя клиента ("Test") */
    public $name;

    /** @var string номер телефона ("+79990009900") */
    public $phone;

    /** @var string дата пойманного лида ("2019-02-18 13:28:48") */
    public $date;

    /** @var string ("test.com/new") */
    public $page;

    /** @var string Источник визита (маркер) ("vk_new") */
    public $marker;

    /** @var string Город визита посетителя ("Москва") */
    public $city;

    /** @var string Страна посетителя ("Россия") */
    public $country;

    /** @var string IP-адрес ("100.100.1.1") */
    public $ip;

    /** @var string первый визит ("1001") */
    public $firstVisit;

    /** @var string Страница с которой перешел посетитель ("vk.com") */
    public $referrer;

    /** @var string домен сайта ("www.test.com") */
    public $domain;

    /** @var string посадочная страница ("test.com/new") */
    public $landingPage;

    /** @var ?string Значение метки utm_source у посетителя */
    public $utmSource;

    /** @var ?string Значение метки utm_medium у посетителя */
    public $utmMedium;

    /** @var ?string Значение метки utm_campaign у посетителя */
    public $utmCampaign;

    /** @var ?string Значение метки utm_term у посетителя */
    public $utmTerm;

    /** @var ?string Значение метки utm_content у посетителя */
    public $utmContent;

    /** @var ?string Значение метки roistat_param1 у посетителя */
    public $roistatParam1;

    /** @var ?string Значение метки roistat_param2 у посетителя */
    public $roistatParam2;

    /** @var ?string Значение метки roistat_param3 у посетителя */
    public $roistatParam3;

    /** @var ?string Значение метки roistat_param4 у посетителя */
    public $roistatParam4;

    /** @var ?string Значение метки roistat_param5 у посетителя */
    public $roistatParam5;

    /** @var ?string */
    public $googleClientId;

    /** @var ?string */
    public $metrikaClientId;

    /** @var ?string ("vk") */
    public $sourceLevel1;

    /** @var ?string ("new") */
    public $sourceLevel2;

    /**
     * @inheritDoc
     */
    public function attributeFields(): array
    {
        return array_merge(parent::attributeFields(), [
            'roistatParam1' => 'roistat_param_1',
            'roistatParam2' => 'roistat_param_2',
            'roistatParam3' => 'roistat_param_3',
            'roistatParam4' => 'roistat_param_4',
            'roistatParam5' => 'roistat_param_5',
            'sourceLevel1' => 'source_level_1',
            'sourceLevel2' => 'source_level_2',
        ]);
    }
}

