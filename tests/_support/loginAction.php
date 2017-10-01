<?php
$I->amOnPage('/');
$I->click('Войти');

$I->fillField('login', 'testing');
$I->fillField('pass', 'testing');
$I->click('Войти');

$I->click('Главная страница');