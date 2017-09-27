<?php
class FirstCest 
{
    public function startPageWorks(AcceptanceTester $I)
    {
        $I->wantToTest('first page');
        $I->amOnPage('/');

        $I->see('GEEKTEST');
        // $I->see('Войти');
        // $I->see('Регистрация');

        // $I->dontSee('Выйти');
        // $I->dontSee('Личный кабинет');
    }
}

