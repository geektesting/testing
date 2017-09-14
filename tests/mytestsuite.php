<?php
namespace tests;

require_once("mathtest.php");

class MyTestSuite extends \PHPUnit\Framework\TestSuite
{
    public static function suite(){
        $suite = new MyTestSuite("TestSet");
        $suite->addTestSuite('MathTest');
        return $suite;
    }
}