<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 30.10.20 21:11:37
 */

declare(strict_types = 1);
namespace dicr\roistat\callback;

use dicr\validate\ValidateException;

use function array_merge;
use function is_array;

/**
 * Ответ от CRM на запрос ClientsCallbackRequest с данными клиентов.
 *
 * @link https://help.roistat.com/integrations/CRM_i_CMS/Svoja_CRM/#crm-_1
 */
class ClientsCallbackResponse extends CallbackResponse
{
    /** @var ClientEntity[] информация о клиентах CRM */
    public $clients;

    /** @var PaginationEntity общее количество данных и кол-во на странице */
    public $pagination;

    /**
     * @inheritDoc
     */
    public static function attributeEntities() : array
    {
        return array_merge(parent::attributeEntities(), [
            'statuses' => [OrderStatusEntity::class],
            'fields' => [FieldEntity::class],
            'managers' => [ManagerEntity::class]
        ]);
    }

    /**
     * @inheritDoc
     */
    public function rules() : array
    {
        return array_merge(parent::rules(), [
            ['clients', 'required'],
            ['clients', function (string $attribute) {
                if (is_array($this->clients)) {
                    foreach ($this->clients as $client) {
                        if (! $client->validate()) {
                            $this->addError($attribute, (new ValidateException($client))->getMessage());
                        }
                    }
                } else {
                    $this->addError($attribute, 'clients должен быть массивом ClientEntity');
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
