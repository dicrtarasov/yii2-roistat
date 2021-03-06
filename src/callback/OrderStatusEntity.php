<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 30.10.20 20:53:02
 */

declare(strict_types = 1);
namespace dicr\roistat\callback;

use dicr\json\JsonEntity;

/**
 * Информация о значении статуса заказа CRM для передачи в Roistat.
 * Для сопоставления статусов заказа CRM со статусами заказов в Roistat.
 *
 * {"id": "1", "name": "Новый"},
 * {"id": "2", "name": "В работе"}
 */
class OrderStatusEntity extends JsonEntity
{
    /** @var string значение статуса заказа в CRM */
    public $id;

    /** @var string название статуса заказа в Roistat */
    public $name;

    /**
     * @inheritDoc
     */
    public function rules() : array
    {
        return [
            ['id', 'trim'],
            ['id', 'required'],

            ['name', 'trim'],
            ['name', 'required']
        ];
    }
}
