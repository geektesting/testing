<?php
class CatsCest 
{
    public function catsPageWorks(AcceptanceTester $I)
    {
        $I->wantToTest('Cats page works');
        $I->amOnPage('/cats');
        $I->see('Категории тестов');
        $I->see('Создать');
        $I->dontSee('Tags Cloud');
    }

    public function catsPageIntegration(AcceptanceTester $I)
    {
        $I->wantToTest('Cats page integration');
        $I->amOnPage('/');

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
    }
}

