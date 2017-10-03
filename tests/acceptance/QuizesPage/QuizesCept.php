<?php
$I = new AcceptanceTester($scenario);
$I->wantToTest('Quizes page works');

require(__DIR__ . '/../../_support/loginAction.php');

$I->amOnPage('/quizes');

$I->see('Тесты');
$I->see('Создать');
$I->dontSee('Tags Cloud');