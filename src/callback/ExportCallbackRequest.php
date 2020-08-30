<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 30.08.20 06:22:11
 */

declare(strict_types = 1);
namespace dicr\roistat\callback;

use function array_merge;

/**
 * Запрос на экспорт заказов CRM от Roistat (action=export).
 *
 * @link https://help.roistat.com/integrations/CRM_i_CMS/Svoja_CRM/#crm-_1
 */
class ExportCallbackRequest extends CallbackRequest
{
    /** @var int дата в формате UNIX-time, после которой были изменения в сделках */
    public $date;

    /** @var int начальное смещение данных от начала выгрузки (от 0) */
    public $offset;

    /**
     * @var ?int лимит данных на страницу.
     * В первом запросе нет limit.
     */
    public $limit;

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            ['date', 'required'],
            ['date', 'integer', 'min' => 1],

            ['offset', 'default', 'value' => 0],
            ['offset', 'integer', 'min' => 0],

            ['limit', 'default'],
            ['limit', 'integer', 'min' => 1]
        ]);
    }
}
