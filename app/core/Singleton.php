<?php
/**
 * Created by PhpStorm.
 * User: skeepy
 * Date: 19.09.2017
 * Time: 2:13
 */

namespace App\Core;

/**
 * Trait Singleton
 * @package Core
 */
trait Singleton
{
    /**
     * @var null
     */
    static private $_instance = null;

    /**
     * Singleton constructor.
     * Защищаем от создания через new Singleton
     */
    private function __construct()
    {
    }

    /**
     * Защищаем от создания через клонирование
     */
    private function __clone()
    {
    }

    /**
     * Возвращаем единственный экземпляр класса
     * @return self
     */
    static public function getInstance() : self
    {
        return self::$_instance ?? self::$_instance = new static();
    }
}