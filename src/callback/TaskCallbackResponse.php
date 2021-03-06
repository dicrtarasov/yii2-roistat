<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 30.10.20 21:11:37
 */

declare(strict_types = 1);
namespace dicr\roistat\callback;

use function array_merge;

/**
 * Ответ от CRM на запрос Roistat TaskCallbackRequest.
 *
 * @link https://help.roistat.com/integrations/CRM_i_CMS/Svoja_CRM/#3-crm-
 */
class TaskCallbackResponse extends CallbackResponse
{
    /** @var string */
    public const STATUS_OK = 'ok';

    /** @var string статус запроса */
    public $status = self::STATUS_OK;

    /** @var string id задачи */
    public $taskId;

    /**
     * @inheritDoc
     */
    public function rules() : array
    {
        return array_merge(parent::rules(), [
            [['status', 'taskId'], 'trim'],
            [['status', 'taskId'], 'required']
        ]);
    }
}
