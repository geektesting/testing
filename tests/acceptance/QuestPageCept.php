<?php
 
$I = new AcceptanceTester($scenario);
$I->wantToTest('Questions page works');
$I->amOnPage('/qcats');

$I->see('Категории вопросов');
$I->see('Создать');
$I->dontSee('Tags Cloud');