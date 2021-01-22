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
 * Ответ от CRM на запрос SchemeCallbackRequest со схемой данных.
 *
 * @link https://help.roistat.com/integrations/CRM_i_CMS/Svoja_CRM/#crm-_1
 */
class SchemeCallbackResponse extends CallbackResponse
{
    /** @var OrderStatusEntity[] информация о значениях статусов заказов CRM */
    public $statuses;

    /** @var FieldEntity[] информация о значения id дополнительных полей заказов CRM */
    public $fields;

    /** @var ManagerEntity[] информация о менеджерах в CRM */
    public $managers;

    /**
     * @inheritDoc
     */
    public function attributeEntities(): array
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
            ['statuses', 'required'],
            ['statuses', function (string $attribute) {
                if (is_array($this->statuses)) {
                    foreach ($this->statuses as $status) {
                        if (! $status instanceof OrderStatusEntity) {
                            $this->addError($attribute, 'statuses должен быть массивом OrderStatusEntity');
                        } elseif (! $status->validate()) {
                            $this->addError($attribute, (new ValidateException($status))->getMessage());
                        }
                    }
                } else {
                    $this->addError($attribute, 'statuses должен быть массивом OrderStatusEntity');
                }
            }],

            ['fields', 'default', 'value' => []],
            ['fields', function (string $attribute) {
                if (is_array($this->fields)) {
                    foreach ($this->fields as $field) {
                        if (! $field instanceof FieldEntity) {
                            $this->addError($attribute, 'fields должен быть массивом OrderStatusEntity');
                        } elseif (! $field->validate()) {
                            $this->addError($attribute, (new ValidateException($field))->getMessage());
                        }
                    }
                } else {
                    $this->addError($attribute, 'fields должен быть массивом FieldEntity');
                }
            }],

            ['managers', 'required'],
            ['managers', function (string $attribute) {
                if (is_array($this->managers)) {
                    foreach ($this->managers as $manager) {
                        if (! $manager instanceof ManagerEntity) {
                            $this->addError($attribute, 'managers должен быть массивом ManagerEntity');
                        } elseif (! $manager->validate()) {
                            $this->addError($attribute, (new ValidateException($manager))->getMessage());
                        }
                    }
                } else {
                    $this->addError($attribute, 'managers должен быть массивом ManagerEntity');
                }
            }]
        ]);
    }
}
