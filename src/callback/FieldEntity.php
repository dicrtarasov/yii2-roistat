<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 30.08.20 05:27:18
 */

declare(strict_types = 1);
namespace dicr\roistat\callback;

use dicr\helper\JsonEntity;

/**
 * Информация о дополнительном поле данных заказа в CRM для передачи в Roistat.
 *
 * Информация о поле:
 * ```
 * "fields": [
 *   {"id": "1", "name": "Способ доставки"},
 *   {"id": "2", "name": "Менеджер"}
 * ],```
 * ```
 *
 * В информации о заказе можно отправлять в Roistat значения этих полей:
 * ```
 * "fields": {
 *   "1": "Курьер",
 *   "2": "Филиал 1"
 * }
 * ```
 */
class FieldEntity extends JsonEntity
{
    /** @var string уникальный идентификатор поля */
    public $id;

    /** @var string название поля в интерфейсе Roistat */
    public $name;

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            [['id', 'name'], 'trim'],
            [['id', 'name'], 'required']
        ];
    }
}
