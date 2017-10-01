<?php
$I = new AcceptanceTester($scenario);
$I->wantToTest('Register page works');
$I->amOnPage('/account/register');

$I->see('Регистрация');
$I->fillField('login', 'testing' . rand(1, 1000));
$I->fillField('pass', 'testing');
$I->click('Войти');

$I->seeCurrentUrlEquals('/account');
