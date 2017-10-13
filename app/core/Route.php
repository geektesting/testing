<?php
/**
 * Created by PhpStorm.
 * User: skeepy
 * Date: 19.09.2017
 * Time: 12:57
 */

namespace App\Core;
use \App\Config;

/**
 * Class Route
 * @package Core
 */
class Route
{
    private $_routes = [];
    private $_mainPart;
    private $_controller;
    private $_action;

    /**
     * Route constructor.
     */
    public function __construct()
    {
        $this->_routes = Config::$router;
    }

    /**
     * Запускам роутер
     */
    public function run()
    {
        $uriParts = explode('?', $_SERVER['REQUEST_URI']);
        $this->_mainPart = trim(array_shift($uriParts), '/');
        $activeRule = [];

        foreach ($this->_routes as $rule => $target)
        {
            $ruleData = explode('/', $rule);
            $pcre = '/';

            foreach($ruleData as $rulePart)
            {
                // если это фиксированная часть
                if (mb_substr($rulePart, 0, 1, 'UTF-8') != '{') {
                    $pcre .= $rulePart;
                // это шаблон
                } else {
                    $pcre .= '([a-z0-9-]+\/)*';
                }
            }

            $pcre .= '/';

            if (preg_match($pcre, $this->_mainPart)) {
                $activeRule['pattern']      = trim($rule, '/');
                $activeRule['controller']   = $target;
                break;
            }
        }

        if (!empty($activeRule)) {
            $this->setUpRouting($activeRule);
        }
    }

    /**
     * Метод назначения управляющих конструкций, исходя из URL
     * @param array $activeRule
     */
    private function setUpRouting(array $activeRule)
    {
        $command        = $activeRule['controller'];
        $urlPartsTmp    = array_filter(explode('/', $this->_mainPart));
        $urlParts       = [];

        foreach($urlPartsTmp as $item)
        {
            if(!empty($item))
                $urlParts[] = $item;
        }

        // если правило - это шаблон
        if (preg_match('/{/', $activeRule['pattern'])) {
            foreach (explode('/', $activeRule['pattern']) as $partKey => $patternPart)
            {
                if (preg_match('/{/', $patternPart)) {
                    $replacer   = $urlParts[$partKey] ?? '';
                    $command    = str_replace($patternPart, $replacer, $command);

                    if (preg_match('/controller/', $patternPart)) {
                        $this->_controller = $replacer;
                    }
                    if (preg_match('/action/', $patternPart)) {
                        $this->_action = $replacer;
                    }
                }
            }
        }

        $this->detectRoute($command);
    }

    /**
     * Правильно именуем контроллер и метод
     * @param string $command
     */
    private function detectRoute(string $command)
    {
        $commandParts = explode('@', $command);

        if (empty($this->_controller) && current($commandParts)) {
            $this->_controller = current($commandParts);
        }

        array_shift($commandParts);

        if (empty($this->_action) && current($commandParts)) {
            $this->_action = array_shift($commandParts);
        }
        // если данные по прежнему пусты устанавливаем значения по умолчанию
        if (empty($this->_controller)) {
            $this->_controller	= 'main';
        }
        if (empty($this->_action)) {
            $this->_action		= 'index';
        }

        $this->_controller	= 'App\\controllers\\' . ucfirst($this->_controller) . 'Controller';
        $this->_action		= 'action' . ucfirst($this->_action);
    }

    /**
     * GetController
     * @return string
     */
    public function getController(): string
    {
        return $this->_controller;
    }

    /**
     * GetAction
     * @return string
     */
    public function getAction(): string
    {
        return $this->_action;
    }

}