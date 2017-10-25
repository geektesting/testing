<?php
$I = new AcceptanceTester($scenario);
$I->wantToTest('Question page integration');

require(__DIR__ . '/../../_support/loginAction.php');

$I->click('Вопросы');
$I->see('Создать');

$I->click('Создать');
$I->see('Новый вопрос');


$I->submitForm('#save-question', array('qCats' => '4',
     'qType' => '2',
     'description' => 'test',
     'answers[]' => 'test',
     'rightAnswer' => '1',
     'submitButton' => 'Сохранить'
));

// $I->click('Сохранить');

$I->seeCurrentUrlEquals('/questions');
$I->see('test');