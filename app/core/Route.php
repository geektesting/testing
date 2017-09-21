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
 * @package App
 */
class Route
{
    /**
     * @var array
     */
    private $_routes    = [];
    private $args       = [];
    private $mainPart;
    private $controller;
    private $action;

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
        $this->mainPart = trim(array_shift($uriParts), '/');
        $args = array_shift($uriParts) ?? '';
        $activeRule = [];

        if (!empty($args))
        {
            $tmp = explode('&', $args);
            foreach ($tmp as $arg)
            {
                $params = explode('=', $arg);

                if (isset($params[0]) && isset($params[1]))
                    $this->args = array_merge($this->args, [$params[0] => $params[1]]);
            }
        }

        foreach ($this->_routes as $rule => $target)
        {
            $ruleData = explode('/', $rule);
            $pcre = '/';

            foreach($ruleData as $rulePart)
            {
                // если это фиксированная часть
                if(mb_substr($rulePart, 0, 1, 'UTF-8') != '{')
                    $pcre .= $rulePart;
                // это шаблон
                else
                    $pcre .= '([a-z0-9-]+\/)*';
            }

            $pcre .= '/';

            if(preg_match($pcre, $this->mainPart))
            {
                $activeRule['pattern']      = trim($rule, '/');
                $activeRule['controller']   = $target;
                break;
            }
        }

        if(!empty($activeRule))
            $this->setUpRouting($activeRule);
    }

    /**
     * Метод назначения управляющих конструкций, исходя из URL
     * @param $activeRule
     */
    private function setUpRouting($activeRule)
    {
        $command        = $activeRule['controller'];
        $urlPartsTmp    = array_filter(explode('/', $this->mainPart));
        $urlParts       = [];

        foreach($urlPartsTmp as $item)
        {
            if(!empty($item))
                $urlParts[] = $item;
        }

        // если правило - это шаблон
        if(preg_match('/{/', $activeRule['pattern']))
        {
            foreach (explode('/', $activeRule['pattern']) as $partKey => $patternPart)
            {
                if (preg_match('/{/', $patternPart))
                {
                    $replacer   = $urlParts[$partKey] ?? '';
                    $command    = str_replace($patternPart, $replacer, $command);

                    if (preg_match('/controller/', $patternPart))
                        $this->controller = $replacer;

                    if (preg_match('/action/', $patternPart))
                        $this->action = $replacer;
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

        if (empty($this->controller) && current($commandParts))
            $this->controller   = current($commandParts);
        array_shift($commandParts);
        if (empty($this->action) && current($commandParts))
            $this->action       = array_shift($commandParts);

        // если данные по прежнему пусты устанавливаем значения по умолчанию
        if (empty($this->controller))
            $this->controller   = 'main';
        if (empty($this->action))
            $this->action       = 'index';

        $this->controller   = 'App\\controllers\\' . ucfirst($this->controller) . 'Controller';
        $this->action       = 'action' . ucfirst($this->action);
    }

    /**
     * @return string
     */
    public function getController(): string
    {
        return $this->controller;
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * @return array
     */
    public function getArgs(): array
    {
        return $this->args;
    }

}