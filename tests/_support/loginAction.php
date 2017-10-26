<?php
$I->amOnPage('/auth');

$I->fillField('login', 'testing');
$I->fillField('pass', 'testing');
$I->click('Вход');