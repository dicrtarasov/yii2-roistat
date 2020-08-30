<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 30.08.20 08:34:31
 */

declare(strict_types = 1);
namespace dicr\roistat\client;

use dicr\http\UrlInfo;

/**
 * Добавление комментария к сделке (см. ProxyLeadAddRequest).
 *
 * @link https://help.roistat.com/integrations/CRM_i_CMS/Dopolnitel%E2%80%99nye_nastroiki_integracii/Peredacha_zajavok_v_CRM_cherez_Roistat_(proksilid)/
 * @link https://help.roistat.com/quick-start/Zagruzka_zajavok_v_Roistat/
 */
class ProxyLeadCommentRequest extends RoistatRequest
{
    /** @var string id заявки, которую вернул ProxyLeadAddRequest */
    public $id;

    /** @var ?string Заголовок для комментария, необязателен */
    public $title;

    /** @var string комментарий к сделке */
    public $message;

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            ['id', 'required'],

            ['title', 'trim'],
            ['title', 'default'],

            ['message', 'trim'],
            ['message', 'required']
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
