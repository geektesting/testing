<?php
$I = new AcceptanceTester($scenario);
$I->wantToTest("Question's category page works");

require(__DIR__ . '/../../_support/loginAction.php');

$I->amOnPage('/qcats');

$I->see('Категории вопросов');
$I->see('Создать');
$I->dontSee('Tags Cloud');