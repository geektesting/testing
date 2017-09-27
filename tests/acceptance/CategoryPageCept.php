<?php

$I = new AcceptanceTester($scenario);
$I->wantToTest('Cats page works');
$I->amOnPage('/cats');

$I->see('Категории тестов');
$I->see('Создать');
$I->dontSee('Tags Cloud');