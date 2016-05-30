<?php
namespace Tests\AppBundle\Utils;
require_once __DIR__ . '/../../../vendor/autoload.php';
use AppBundle\Utils\Calculator;

class CalculatorTest extends \PHPUnit_Framework_TestCase
{
    public function testAdd()
    {
        $calc = new Calculator();
        $result = $calc->add(30, 12);
        $this->assertEquals(42, $result);
    }

}