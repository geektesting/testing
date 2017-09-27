<?php
class MainCest 
{
    public function frontPageWorks(AcceptanceTester $I)
    {
        $I->wantToTest('first page');
        $I->amOnPage('/');

        $I->see('GEEKTEST');
        $I->see('Выйти');
        $I->see('Личный кабинет');
        
        $I->dontSee('Войти');
        $I->dontSee('Регистрация');
    }
}

