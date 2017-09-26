<?php
class QuestCest 
{
    public function questPageWorks(AcceptanceTester $I)
    {
        $I->wantToTest('Questions page works');
        $I->amOnPage('/qcats');
        $I->see('Категории вопросов');
        $I->see('Создать');
        $I->dontSee('Tags Cloud');
    }

    public function questPageIntegration(AcceptanceTester $I)
    {
        $I->wantToTest('Questions page integration');
        $I->amOnPage('/');

        $I->click('Категории вопросов');
        $I->see('Создать');

        $I->click('Создать');
        $I->see('Создание категории');

        $I->fillField('cat_name', 'testCat');
        $I->click('Сохранить');

        $I->seeCurrentUrlEquals('/qcats');
        $I->see('testCat');
        $I->click('testName');

        $I->canSeeInField('cat_name', 'testCat');
        $I->fillField('cat_name', 'testCat2');
        $I->click('Сохранить');

        $I->seeCurrentUrlEquals('/qcats');
        $I->see('testCat2');
    }
}