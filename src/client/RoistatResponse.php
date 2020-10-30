<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 30.10.20 20:53:02
 */

declare(strict_types = 1);
namespace dicr\roistat\client;

use dicr\json\JsonEntity;

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
