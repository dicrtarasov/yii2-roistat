<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 30.08.20 07:16:12
 */

declare(strict_types = 1);
namespace dicr\roistat\callback;

/**
 * Запрос к CRM от Roistat на добавление задачи к существующей заявке (action=task).
 *
 * @link https://help.roistat.com/integrations/CRM_i_CMS/Svoja_CRM/#_5
 */
class TaskCallbackRequest extends CallbackRequest
{
    /** @var ?string ID сделки или иной сущности, в которую необходимо добавить задачу */
    public $elementId;

    /** @var ?string крайний срок задачи (UTC+0) 2019-01-01T11:11:11 */
    public $deadline;

    /** @var ?string текст задачи */
    public $text;
}
