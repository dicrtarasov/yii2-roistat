<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 30.10.20 20:54:49
 */

declare(strict_types = 1);
namespace dicr\roistat\callback;

use dicr\json\JsonEntity;

use function array_merge;

/**
 * Информация о лиде/визите в Roistat.
 */
class VisitInfo extends JsonEntity
{
    /** @var string уникальный номер письма в Roistat ("111") */
    public $id;

    /** @var string IP-адрес ("100.100.1.1") */
    public $ip;

    /** @var string Источник визита (маркер) ("vk_new") */
    public $marker;

    /** @var string Город визита посетителя ("Москва") */
    public $city;

    /** @var string Страна посетителя ("Россия") */
    public $country;

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

    /**
     * @inheritDoc
     */
    public static function attributeFields() : array
    {
        return array_merge(parent::attributeFields(), [
            'roistatParam1' => 'roistat_param_1',
            'roistatParam2' => 'roistat_param_2',
            'roistatParam3' => 'roistat_param_3',
            'roistatParam4' => 'roistat_param_4',
            'roistatParam5' => 'roistat_param_5'
        ]);
    }
}
