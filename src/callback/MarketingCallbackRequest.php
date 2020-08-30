<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 30.08.20 06:01:44
 */

declare(strict_types = 1);
namespace dicr\roistat\callback;

/**
 * WebHook Roistat при наступлении события сервиса "Автоматизация маркетинга".
 *
 * @link https://help.roistat.com/features/Avtomatizacija_marketinga/
 */
class MarketingCallbackRequest extends CallbackRequest
{
    /** @var string событие ("order_created") */
    public $eventType;

    /** @var string ("19") */
    public $scriptId;

    /** @var string ("Новая сделка") */
    public $scriptName;

    /** @var ?VisitInfo информация о визите */
    public $visit;

    /** @var ?OrderInfo информация о заказе */
    public $order;

    /** @var ?ClientInfo информация о клиенте */
    public $client;

    /**
     * @inheritDoc
     */
    public function attributeEntities() : array
    {
        return [
            'visit' => VisitInfo::class,
            'order' => OrderInfo::class,
            'client' => ClientInfo::class
        ];
    }
}
