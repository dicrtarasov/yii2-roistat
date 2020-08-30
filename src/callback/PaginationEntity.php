<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 30.08.20 05:30:25
 */

declare(strict_types = 1);
namespace dicr\roistat\callback;

use dicr\helper\JsonEntity;

/**
 * Информация о постраничных параметрах для передачи в Roistat.
 * CRM принимает запросы от Roistat и возвращает limit данных за один запрос.
 */
class PaginationEntity extends JsonEntity
{
    /** @var int общее количество записей */
    public $totalCount;

    /** @var int кол-во записей в одном запросе */
    public $limit;

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            ['totalCount', 'required'],
            ['totalCount', 'integer', 'min' => 0],

            ['limit', 'required'],
            ['limit', 'integer', 'min' => 1]
        ];
    }
}
