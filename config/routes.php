<?php
/**
 * Created by PhpStorm.
 * User: skeepy
 * Date: 19.09.2017
 * Time: 12:58
 */

return [
    'about'                    => 'main@about',

    'user/{action}'            => 'user@{action}',

    '{controller}/{action}'    => '{controller}@{action}',

    ''                         => 'main@index'
];