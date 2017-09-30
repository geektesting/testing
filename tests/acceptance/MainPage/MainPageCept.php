<?php
$I = new AcceptanceTester($scenario);
$I->wantToTest('main page');

require(__DIR__ . '/../../_support/loginAction.php');

$I->see('GEEKTEST');
$I->see('Выйти');
$I->see('Личный кабинет');

$I->dontSee('Войти');
$I->dontSee('Регистрация');
