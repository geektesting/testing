<?php
class FirstCest 
{
    public function frontPageWorks(AcceptanceTester $I)
    {
        $I->wantToTest('first page');
        $I->amOnPage('/');
        $I->see('GEEKTEST');  
    }
}

