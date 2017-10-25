<?php
$I = new AcceptanceTester($scenario);
$I->wantToTest('Main page integration');

require(__DIR__ . '/../../_support/loginAction.php');

$I->see('GEEKTEST');
$I->see('Выйти');

$I->see('JavaScript (1)');
$I->click('JavaScript (1)');

$I->see('Тест по Javascript');
$I->click('JavaScript (1)');

$I->see('Начать тест');
$I->click('Начать тест');

$I->see('Вопрос 1');

for ($i = 1; $i < 11; $i++) {
    $I->selectOption('answer', $i);
    $I->click('Сохранить');
}

$I->see('Ваш результат');