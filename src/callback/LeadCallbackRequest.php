<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 30.08.20 06:55:23
 */

declare(strict_types = 1);
namespace dicr\roistat\callback;

/**
 * Запрос от Roistat на добавление лида в CRM (action=lead).
 *
 * @link https://help.roistat.com/integrations/CRM_i_CMS/Svoja_CRM/#3-crm-
 */
class LeadCallbackRequest extends CallbackRequest
{
    /** @var string Заголовок новой заявки */
    public $title;

    /**
     * @var array
     * В данном параметре передается JSON дополнительных полей заявки.
     * В том числе поля roistat, где содержится номер визита. Данные содержатся в формате:
     * "custom_field":"value".
     */
    public $data;

    /**
     * @var string Ответственный менеджер, который указан на этапе "отправка данных в CRM".
     */
    public $managerId;

    /** @var string  Email адрес клиента, оставившего заявку. */
    public $email;

    /** @var string Имя клиента, оставившего заявку */
    public $name;

    /** @var string Номер телефона клиента, оставившего заявку */
    public $phone;

    /** @var string Комментарий заявки, содержащий дополнительную информацию. */
    public $text;
}
