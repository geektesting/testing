<?php
$I = new AcceptanceTester($scenario);
$I->wantToTest('Quizes page integration');

require(__DIR__ . '/../../_support/loginAction.php');

$I->click('Тесты');
$I->see('Создать');

$I->click('Создать');
$I->see('Новый тест');

$I->fillField('quizName', 'testQuiz');
$I->selectOption('catName', '4');
$I->selectOption('qCats[]', 'JS-2. Строки');
$I->click('Сохранить');

$I->seeCurrentUrlEquals('/quizes');
$I->see('testQuiz');
$I->click('testQuiz');

$I->canSeeInField('quizName', 'testQuiz');
$I->fillField('quizName', 'testQuiz2');
$I->click('Сохранить');

$I->seeCurrentUrlEquals('/quizes');
$I->see('testQuiz2');