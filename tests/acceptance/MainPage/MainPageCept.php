<?php
$I = new AcceptanceTester($scenario);
$I->wantToTest('Main page');

require(__DIR__ . '/../../_support/loginAction.php');

$I->see('GEEKTEST');
$I->see('Выйти');

$I->dontSee('Войти');
$I->dontSee('Регистрация');
