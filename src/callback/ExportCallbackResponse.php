<?php
/*
 * @copyright 2019-2021 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 22.01.21 16:47:33
 */

declare(strict_types = 1);
namespace dicr\roistat\callback;

use dicr\validate\ValidateException;

use function array_merge;
use function is_array;

/**
 * Ответ от CRM с данными заказов для Roistat.
 *
 * @link https://help.roistat.com/integrations/CRM_i_CMS/Svoja_CRM/#crm-_1
 */
class ExportCallbackResponse extends SchemeCallbackResponse
{
    /** @var OrderEntity[] информация о запрошенных заказах */
    public $orders;

    /**
     * @var PaginationEntity информация об общем количестве и лимите данных на странице.
     * В зависимости от параметров totalCount и limit, Roistat будет совершать дополнительные
     * запросы к странице выгрузки. В первом запросе нет limit. Затем, при обновлении запросов limit и offset,
     * Roistat выгрузит все измененные сделки за выбранный запросом offset период.
     * Параметр totalCount должен быть неизменным для всех страниц.
     */
    public $pagination;

    /**
     * @inheritDoc
     */
    public function attributeEntities(): array
    {
        return array_merge(parent::attributeEntities(), [
            'orders' => [OrderEntity::class],
            'pagination' => PaginationEntity::class
        ]);
    }

    /**
     * @inheritDoc
     */
    public function rules() : array
    {
        return array_merge(parent::rules(), [
            ['orders', 'required'],
            ['orders', function (string $attribute) {
                if (is_array($this->orders)) {
                    foreach ($this->orders as $order) {
                        if (! $order instanceof OrderEntity) {
                            $this->addError($attribute, 'orders должен быть массивом OrderEntity');
                        } elseif (! $order->validate()) {
                            $this->addError($attribute, (new ValidateException($order))->getMessage());
                        }
                    }
                } else {
                    $this->addError($attribute, 'orders должен быть массивом OrderEntity');
                }
            }],

            ['pagination', 'required'],
            ['pagination', function (string $attribute) {
                if (! $this->pagination instanceof PaginationEntity) {
                    $this->addError($attribute, 'pagination должен иметь тип PaginationEntity');
                }
            }]
        ]);
    }
}
