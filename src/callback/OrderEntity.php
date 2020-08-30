<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 30.08.20 05:27:58
 */

declare(strict_types = 1);
namespace dicr\roistat\callback;

use dicr\helper\JsonEntity;

use function array_merge;
use function is_array;

/**
 * Информация о заказе в CRM для передачи в Roistat.
 */
class OrderEntity extends JsonEntity
{
    /** @var string Уникальный идентификатор сделки ("100") */
    public $id;

    /** @var ?string Название сделки. Используется в интерфейсе Roistat ("Новая сделка") */
    public $name;

    /**
     * @var string дата создания заказа ("1393673200")
     * Дата создания сделки в формате UNIX-time или YYYY-MM-DD HH:MM
     */
    public $dateCreate;

    /** @var string Уникальный идентификатор статуса из массива statuses ("1") */
    public $status;

    /** @var ?float Сумма сделки. Используется в показателе «Выручка» в Roistat. (120.34) */
    public $price;

    /** @var ?float Себестоимость сделки. Используется в показателе «Себестоимость» в Roistat. (100.34) */
    public $cost;

    /**
     * @var ?string ("3121512")
     * Номер визита, сохраненный у сделки. Значение cookie roistat_visit.
     * Используется для определения источника сделки
     */
    public $roistat;

    /** @var ?string Идентификатор клиента в CRM ("1") */
    public $clientId;

    /**
     * @var ?string ("1")
     * Идентификатор менеджера массива managers.
     */
    public $managerId;

    /**
     * @var ?FieldEntity[] значения дополнительных полей
     */
    public $fields;

    /**
     * @inheritDoc
     */
    public function attributeEntities() : array
    {
        return array_merge(parent::attributeEntities(), [
            'fields' => [FieldEntity::class]
        ]);
    }

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            ['id', 'trim'],
            ['id', 'required'],

            ['name', 'trim'],
            ['name', 'default'],

            ['dateCreate', 'trim'],
            ['dateCreate', 'required'],

            ['status', 'trim'],
            ['status', 'required'],

            [['price', 'cost'], 'default'],
            [['price', 'cost'], 'number', 'min' => 0.01],

            [['roistat', 'clientId', 'managerId'], 'trim'],
            [['roistat', 'clientId', 'managerId'], 'default'],

            ['fields', 'default'],
            ['fields', function (string $attribute) {
                if (! is_array($this->fields)) {
                    $this->addError($attribute, 'fields должен быть массивом');
                }
            }]
        ];
    }
}
