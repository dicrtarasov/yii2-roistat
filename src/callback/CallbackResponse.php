<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 30.08.20 08:01:40
 */

declare(strict_types = 1);
namespace dicr\roistat\callback;

use dicr\helper\JsonEntity;

/**
 * Ответ от CRM на callback-запрос от Roistat.
 */
abstract class CallbackResponse extends JsonEntity
{

}
