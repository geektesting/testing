<?php
$I = new AcceptanceTester($scenario);
$I->wantToTest('Auth page works');
$I->amOnPage('/auth');

$I->see('Авторизация');
$I->fillField('login', 'testing');
$I->fillField('pass', 'testing');
$I->click('Вход');

$I->seeCurrentUrlEquals('/account');