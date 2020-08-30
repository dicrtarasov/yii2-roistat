<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 30.08.20 09:00:54
 */

declare(strict_types = 1);
namespace dicr\roistat\callback;

/**
 * Запрос от Roistat на добавление лида в CRM (action=lead).
 *
 * @link https://help.roistat.com/integrations/CRM_i_CMS/Svoja_CRM/#3-crm-
 * @link https://help.roistat.com/integrations/CRM_i_CMS/Webhook_dlja_otpravki_zajavok/
 */
class LeadCallbackRequest extends CallbackRequest
{
    /** @var string Тип события ("lead") */
    public $action;

    /** @var ?string Идентификатор отправляемой заявки ("90") */
    public $id;

    /** @var string Номер визита, в котором содержится источник заявки ("12852") */
    public $visit;

    /**
     * @var string Заголовок новой заявки.
     * Для звонка из Коллтрекинга. Для заявки из Ловца лидов. Для заявки из JivoSite
     * ("Звонок от 79990001122. Пойманный лид: 79990001122. JivoSite Lead")
     */
    public $title;

    /**
     * @var string
     * Дополнительная информация о заявке. Обычно отправляется в комментарий к сделке.
     * Для Коллтрекинга здесь же передается информация о набранном номере.
     * ("Данные формы: 79990001122. Промокод: 1674. Страница захвата: http://site.ru. Дата отправки: 17:22 15.04.2015")
     */
    public $text;

    /** @var string Используется для поля Имя в форме Ловца лидов. ("Иван") */
    public $name;

    /** @var string Номер набранного телефона или поле Телефон в форме Ловца лидов ("+79990001122") */
    public $phone;

    /**
     * @var string  Email адрес клиента, оставившего заявку.
     * Используется для адреса почты в форме представления для JivoSite
     */
    public $email;

    /**
     * @var array
     * В данном параметре передается JSON дополнительных полей заявки.
     * В том числе поля roistat, где содержится номер визита. Данные содержатся в формате:
     * "custom_field":"value".
     * Используется для Ловца лидов. data - это json, в котором ключ page и значение - Страница захвата.
     * Дополнительные поля и значения дополнительных полей также передаются в data.
     */
    public $data;

    /** @var string Дата и время получения лида сервером Roistat (UTC+0) ("2015-06-28 09:12:54") */
    public $createdDate;

    /**
     * @var string Ответственный менеджер, который указан на этапе "отправка данных в CRM".
     */
    public $managerId;
}
