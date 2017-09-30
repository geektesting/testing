<?php
$I = new AcceptanceTester($scenario);
$I->wantToTest('Cats page integration');

require(__DIR__ . '/../../_support/loginAction.php');

$I->click('Категории тестов');
$I->see('Создать');

$I->click('Создать');
$I->see('Создание категории');

$I->fillField('catName', 'testName');
$I->selectOption('parent', 'JavaScript');
$I->click('Сохранить');

$I->seeCurrentUrlEquals('/cats');
$I->see('Ожидает одобрения');
$I->see('testName');
$I->click('testName');

$I->canSeeInField('catName', 'testName');
$I->fillField('catName', 'testName2');
$I->selectOption('parent', 'PHP');
$I->click('Сохранить');

$I->seeCurrentUrlEquals('/cats');
$I->see('Ожидает одобрения');
$I->see('testName2');