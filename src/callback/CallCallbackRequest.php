<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 30.08.20 07:28:38
 */

declare(strict_types = 1);
namespace dicr\roistat\callback;

/**
 * Запрос к CRM от Roistat на добавление звонка к существующей заявке (action=call).
 *
 * @link https://help.roistat.com/integrations/CRM_i_CMS/Svoja_CRM/#_6
 */
class CallCallbackRequest extends CallbackRequest
{
    /** @var string звонок был принят и обработан сотрудником */
    public const STATUS_ANSWER = 'ANSWER';

    /** @var string входящий звонок был, но линия была занята */
    public const STATUS_BUSY = 'BUSY';

    /** @var string входящий вызов состоялся, но в течение времени ожидания ответа не был принят сотрудником */
    public const STATUS_NOANSWER = 'NOANSWER';

    /** @var string входящий вызов состоялся, но был завершен до того, как сотрудник ответил */
    public const STATUS_CANCEL = 'CANCEL';

    /** @var string вызов не состоялся из-за технических проблем */
    public const STATUS_CONGESTION = 'CONGESTION';

    /** @var string вызываемый номер был недоступен */
    public const STATUS_CHANUNAVAIL = 'CHANUNAVAIL';

    /** @var string входящий вызов был отменен */
    public const STATUS_DONTCALL = 'DONTCALL';

    /** @var string входящий вызов был перенаправлен на автоответчик */
    public const STATUS_TORTURE = 'TORTURE';

    /** @var string ID звонка в системе Roistat ("12") */
    public $id;

    /** @var string кому был совершен вызов ("78002225566") */
    public $callee;

    /** @var string кто совершил вызов ("78002225566") */
    public $caller;

    /** @var string дата звонка (UTC+0) ("2019-01-01T11:11:11") */
    public $date;

    /** @var string номер визита ("12345") */
    public $visit;

    /** @var string маркер, рекламный источник визита ("vk_new_post") */
    public $marker;

    /** @var string статус звонка */
    public $status;

    /** @var string номер сделки, которая была создана по звонку ("12345") */
    public $orderId;

    /** @var string длительность вызова */
    public $duration;

    /** @var string запись разговора */
    public $fileUrl;
}
