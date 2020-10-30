<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 30.10.20 21:11:37
 */

declare(strict_types = 1);
namespace dicr\roistat\client;

use dicr\validate\ValidateException;

use function array_merge;
use function is_array;

/**
 * Абстрактный запрос данных к Roistat.
 */
abstract class RoistatDataRequest extends RoistatRequest
{
    /** @var ?string[] список дополнительных полей (вложенные объекты), которые нужно вернуть дополнительно */
    public $extend;

    /** @var ?array структура фильтров (and, or, RoistatFilter) */
    public $filters;

    /** @var ?RoistatSort сортировка */
    public $sort;

    /** @var ?int смещение (начиная с 0) */
    public $offset;

    /** @var ?int ограничение количества */
    public $limit;

    /**
     * @inheritDoc
     */
    public static function attributeEntities() : array
    {
        return array_merge(parent::attributeEntities(), [
            'sort' => RoistatSort::class
        ]);
    }

    /**
     * @inheritDoc
     */
    public function rules() : array
    {
        return array_merge(parent::rules(), [
            ['extend', 'default'],
            ['extend', function (string $attribute) {
                if (! is_array($this->extend)) {
                    $this->addError($attribute, 'extend должен быть массивом названий полей');
                }
            }],

            ['filters', 'default'],
            ['filters', function (string $attribute) {
                if (! is_array($this->filters)) {
                    $this->addError($attribute, 'Фильтры должны быть массивом');
                }
            }],

            ['sort', 'default'],
            ['sort', function (string $attribute) {
                if (is_array($this->sort)) {
                    $this->sort = new RoistatSort([
                        'json' => $this->sort
                    ]);
                }

                if (! $this->sort instanceof RoistatSort) {
                    $this->addError($attribute, 'sort должен быть массивом или RoistatSort');
                } elseif (! $this->sort->validate()) {
                    $this->addError($attribute, (new ValidateException($this->sort))->getMessage());
                }
            }],

            ['offset', 'default'],
            ['offset', 'integer', 'min' => 0],

            ['limit', 'default'],
            ['limit', 'integer', 'min' => 1]
        ]);
    }
}
