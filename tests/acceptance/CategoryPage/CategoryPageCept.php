<?php
$I = new AcceptanceTester($scenario);
$I->wantToTest('Cats page works');

require(__DIR__ . '/../../_support/loginAction.php');

$I->amOnPage('/cats');;

$I->see('Категории тестов');
$I->see('Создать');
$I->dontSee('Tags Cloud');