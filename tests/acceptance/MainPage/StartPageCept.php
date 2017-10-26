<?php
$I = new AcceptanceTester($scenario);
$I->wantToTest('First page');
$I->amOnPage('/');

$I->see('GEEKTEST');
$I->see('Войти');
$I->see('Регистрация');

$I->dontSee('Выйти');


