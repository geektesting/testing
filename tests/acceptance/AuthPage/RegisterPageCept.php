<?php
$I = new AcceptanceTester($scenario);
$I->wantToTest('Register page works');
$I->amOnPage('/account/register');

$I->see('Регистрация');
$I->fillField('login', 'testing' . rand(1, 1000));
$I->fillField('e_mail', 'testing' . rand(1, 1000) . '@test.io');
$I->fillField('pass', 'testing');
$I->fillField('pass2', 'testing');
$I->click('Вход');

$I->seeCurrentUrlEquals('/');
