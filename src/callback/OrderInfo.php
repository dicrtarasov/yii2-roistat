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
 * Информация о сделке в Roistat.
 */
class OrderInfo extends JsonEntity
{
    /** @var string Уникальный идентификатор сделки ("100") */
    public $id;

    /** @var float (120) */
    public $price;

    /** @var float (100) */
    public $cost;

    /** @var string "Новая" */
    public $status;
}
