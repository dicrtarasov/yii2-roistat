<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 30.08.20 04:36:21
 */

declare(strict_types = 1);
namespace dicr\roistat\callback;

use dicr\helper\JsonEntity;

/**
 * Информация о клиенте.
 */
class ClientInfo extends JsonEntity
{
    /** @var string ("2") */
    public $externalId;

    /** @var string ("Test Client") */
    public $name;

    /** @var ?string */
    public $company;

    /** @var string ("79012223344") */
    public $phone;

    /** @var string ("test@client.com") */
    public $email;
}
