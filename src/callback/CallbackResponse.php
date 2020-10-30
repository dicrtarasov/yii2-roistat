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
 * Ответ от CRM на callback-запрос от Roistat.
 */
abstract class CallbackResponse extends JsonEntity
{
    // noop
}
