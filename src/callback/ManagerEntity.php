<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 30.10.20 21:11:37
 */

declare(strict_types = 1);
namespace dicr\roistat\callback;

use dicr\json\JsonEntity;

/**
 * Информация о менеджере в CRM для передачи в Roistat.
 */
class ManagerEntity extends JsonEntity
{
    /** @var string Уникальный идентификатор менеджера. ("id") */
    public $id;

    /** @var string Имя менеджера. Используется в интерфейсе Roistat  ("Менеджер 1") */
    public $name;

    /** @var string Телефон менеджера ("79012223355") */
    public $phone;

    /** @var string Электронная почта менеджера ("test1@mail.com") */
    public $email;

    /**
     * @inheritDoc
     */
    public function rules() : array
    {
        return [
            [['id', 'name', 'phone', 'email'], 'trim'],
            [['id', 'name', 'phone', 'email'], 'required']
        ];
    }
}
