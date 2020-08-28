<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 29.08.20 01:47:12
 */

declare(strict_types = 1);
namespace dicr\roistat;

use dicr\helper\JsonEntity;

/**
 * Ответ Roistat.
 */
class RoistatResponse extends JsonEntity
{
    /** @var string */
    public const STATUS_SUCCESS = 'success';

    /** @var string */
    public const STATUS_ERROR = 'error';

    /** @var string статус */
    public $status;

    /** @var mixed данные ответа */
    public $data;

    /** @var int общее кол-во данных (если в data данные) */
    public $total;

    /** @var string ошибка */
    public $error;
}
