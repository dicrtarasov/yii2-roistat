<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 01.09.20 17:37:16
 */

declare(strict_types = 1);
namespace dicr\roistat\client;

use dicr\helper\JsonEntity;

use function array_shift;

use const SORT_ASC;
use const SORT_DESC;

/**
 * Параметры сортировки.
 */
class RoistatSort extends JsonEntity
{
    /** @var string */
    public const SORT_ASC = 'asc';

    /** @var string */
    public const SORT_DESC = 'desc';

    /** @var string поле сортировки */
    public $field;

    /** @var string направление сортировки */
    public $order;

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            ['field', 'required'],
            ['field', 'string'],

            ['order', 'default', 'value' => self::SORT_ASC],
            ['order', function ($attribute) {
                if ($this->order === SORT_ASC) {
                    $this->order = self::SORT_ASC;
                } elseif ($this->order === SORT_DESC) {
                    $this->order = self::SORT_DESC;
                } elseif ($this->order !== self::SORT_ASC && $this->order !== self::SORT_DESC) {
                    $this->addError($attribute, 'Некорректный порядок сортировки: ' . $this->order);
                }
            }]
        ];
    }

    /**
     * @inheritDoc
     */
    public function getJson() : array
    {
        return [$this->field, $this->order];
    }

    /**
     * @inheritDoc
     */
    public function setJson(array $json, bool $skipUnknown = true)
    {
        $this->field = array_shift($json);
        $this->order = array_shift($json);
    }
}
