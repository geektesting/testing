<?php
namespace tests;

class MathTest extends \PHPUnit\Framework\TestCase
{
    private $math;
 
    protected function setUp()
    {
        $this->math = 3;
    }
 
    protected function tearDown()
    {
        $this->math = NULL;
    }
 
    public function testAdd()
    {
        $result = $this->math;
        $this->assertEquals(3, $result);
    }
}