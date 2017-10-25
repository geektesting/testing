<?php
$I = new AcceptanceTester($scenario);
$I->wantToTest('Question page integration');

require(__DIR__ . '/../../_support/loginAction.php');

$I->click('Вопросы');
$I->see('Создать');

$I->click('Создать');
$I->see('Новый вопрос');

$I->selectOption('qCats', '4');
$I->selectOption('qType', '2');
$I->fillField('description', 'test');
$I->fillField('answers[]', 'test');
$I->selectOption('rightAnswer', '1');

$I->click('Сохранить');

$I->seeCurrentUrlEquals('/questions\/');
$I->see('test');
$I->click('test');

$I->canSeeInField('description', 'test');
$I->fillField('description', 'test2');
$I->click('Сохранить');

$I->seeCurrentUrlEquals('/questions\/');
$I->see('test2');