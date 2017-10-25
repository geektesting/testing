<?php
$I = new AcceptanceTester($scenario);
$I->wantToTest('Questions page works');

require(__DIR__ . '/../../_support/loginAction.php');

$I->amOnPage('/questions');

$I->see('Вопросы');
$I->see('Создать');
$I->dontSee('Tags Cloud');