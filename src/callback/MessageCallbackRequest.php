<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 30.10.20 20:54:14
 */

declare(strict_types = 1);
namespace dicr\roistat\callback;

/**
 * Запрос к CRM от Roistat на добавление комментария к существующей заявке (action=message).
 *
 * @link https://help.roistat.com/integrations/CRM_i_CMS/Svoja_CRM/#_4
 */
class MessageCallbackRequest extends CallbackRequest
{
    /** @var ?string ID сделки или иной сущности, в которую необходимо добавить сообщение; */
    public $leadId;

    /** @var ?string заголовок сообщения */
    public $title;

    /** @var ?string текст сообщения */
    public $message;

    /**
     * @inheritDoc
     */
    public static function attributeFields() : array
    {
        return [
            // не преобразовываем поле в snake_case
            'leadId' => 'leadId'
        ];
    }
}
