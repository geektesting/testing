<?php
$I = new AcceptanceTester($scenario);
$I->wantToTest('Main page integration');

require(__DIR__ . '/../../_support/loginAction.php');

$I->see('GEEKTEST');
$I->see('Выйти');

$I->see('PHP (2)');
$I->click('PHP (2)');

$I->see('PHP');