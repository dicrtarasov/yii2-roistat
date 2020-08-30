<?php
/*
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 30.08.20 08:31:39
 */

declare(strict_types = 1);
namespace dicr\roistat\callback;

use dicr\helper\JsonEntity;
use dicr\roistat\RoistatModule;

/**
 * Запрос данных от Roistat к CRM.
 *
 * @property-read RoistatModule $module
 */
abstract class CallbackRequest extends JsonEntity
{
    /** @var RoistatModule */
    protected $_module;

    /**
     * RoistatCallback constructor.
     *
     * @param RoistatModule $module
     * @param array $config
     */
    public function __construct(RoistatModule $module, $config = [])
    {
        $this->_module = $module;

        parent::__construct($config);
    }

    /**
     * Модуль Roistat.
     *
     * @return RoistatModule
     */
    public function getModule() : RoistatModule
    {
        return $this->_module;
    }
}
