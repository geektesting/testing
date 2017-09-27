<?php

$I = new AcceptanceTester($scenario);
$I->wantToTest('main page');
$I->amOnPage('/');

$I->see('GEEKTEST');
$I->see('Выйти');
$I->see('Личный кабинет');

$I->dontSee('Войти');
$I->dontSee('Регистрация');
