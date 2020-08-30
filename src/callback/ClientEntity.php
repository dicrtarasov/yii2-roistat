<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 30.08.20 06:31:39
 */

declare(strict_types = 1);
namespace dicr\roistat\callback;

use dicr\helper\JsonEntity;

use function array_merge;

/**
 * Информация о клиенте CRM.
 */
class ClientEntity extends JsonEntity
{
    /** @var string Уникальный идентификатор клиента ("2") */
    public $id;

    /** @var string Название клиента. Используется в интерфейсе Roistat ("Иван Иванович") */
    public $name;

    /** @var string Телефон клиента ("71111111111") */
    public $phone;

    /** @var string Электронный адрес клиента ("ivan@client.com") */
    public $email;

    /** @var ?string Название компании ("ООО Компания") */
    public $company;

    /** @var ?string День рождения в формате Y-m-d ("1990-04-15") */
    public $birthDate;

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['id', 'name', 'phone', 'email', 'company', 'birthDate'], 'trim'],

            [['id', 'name', 'phone', 'email'], 'required'],

            [['company', 'birthDate'], 'default'],

            ['birthDate', 'date', 'format' => 'php:Y-m-d']
        ]);
    }
}
