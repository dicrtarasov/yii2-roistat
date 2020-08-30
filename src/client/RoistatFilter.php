<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 30.08.20 08:34:31
 */

declare(strict_types = 1);
namespace dicr\roistat\client;

use dicr\helper\JsonEntity;

use function array_shift;
use function in_array;
use function is_array;
use function is_scalar;

/**
 * Условие фильтра данных.
 *
 * Используется для указания условий фильтра данных в запросе.
 */
class RoistatFilter extends JsonEntity
{
    /** @var string Операторы сравнения */
    public const OP_LESS = '<';

    /** @var string Операторы сравнения */
    public const OP_LESS_EQUALS = '<=';

    /** @var string Операторы сравнения */
    public const OP_EQUALS = '=';

    /** @var string Операторы сравнения */
    public const OP_NOT_EQUALS = '!=';

    /** @var string Операторы сравнения */
    public const OP_MORE = '>';

    /** @var string Операторы сравнения */
    public const OP_MORE_EQUALS = '>=';

    /** @var string Проверка вхождения значения параметра в предполагаемый массив из параметров */
    public const OP_IN = 'in';

    /** @var string Если указать значение 0, то идет проверка на IS NOT NULL. Если 1, то IS NULL. */
    public const OP_NULL = 'null';

    /** @var string Проверка совпадения. Аналог %LIKE% */
    public const OP_LIKE = 'like';

    /** @var string[] операторы сравнения */
    public const OPS = [
        self::OP_LESS, self::OP_LESS_EQUALS, self::OP_EQUALS, self::OP_NOT_EQUALS,
        self::OP_MORE, self::OP_MORE_EQUALS, self::OP_IN, self::OP_NULL, self::OP_LIKE
    ];

    /** @var string фильтруемое поле данных */
    public $field;

    /** @var string оператор сравнения */
    public $op;

    /** @var mixed сравниваемое значение */
    public $value;

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            ['field', 'required'],
            ['field', 'string'],

            ['op', 'required'],
            ['op', 'in', 'range' => self::OPS],

            ['value', 'required'],
            ['value', function (string $attribute) {
                if ($this->op === self::OP_NULL) {
                    if (in_array($this->value, [0, 1, '0', '1', false, true], true)) {
                        $this->value = (int)(bool)$this->value;
                    } else {
                        $this->addError($attribute, 'Значение должно быть типа boolean');
                    }
                } elseif ($this->op === self::OP_IN) {
                    if (! is_array($this->value)) {
                        $this->addError($attribute, 'Значение должно быть массивом');
                    }
                } elseif (! is_scalar($this->value)) {
                    $this->addError($attribute, 'Значение должно быть скалярным типом');
                }
            }]
        ];
    }

    /**
     * @inheritDoc
     */
    public function getJson() : array
    {
        return [$this->field, $this->op, $this->value];
    }

    /**
     * @inheritDoc
     */
    public function setJson(array $json)
    {
        $this->field = array_shift($json);
        $this->op = array_shift($json);
        $this->value = array_shift($json);
    }
}
