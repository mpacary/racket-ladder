<?php

include_once dirname(__FILE__).'/bootstrap.php';

class MathTest extends PHPUnit_Framework_TestCase
{
  
  function testMedian()
  {
    $this->assertEquals(1.5, Math::array_median(array(1, 2)), '', 0.01);
    $this->assertEquals(1.5, Math::array_median(array(0, 1, 2, 10000)), '', 0.01);
    $this->assertEquals(1.5, Math::array_median(array(0, 10000, 2, 1)), '', 0.01);
    $this->assertEquals(2, Math::array_median(array(1, 2, 3)), '', 0.01);
    $this->assertEquals(2, Math::array_median(array(1, 2, 20)), '', 0.01);
    $this->assertEquals(20, Math::array_median(array(1, 20, 20)), '', 0.01);
    $this->assertEquals(2, Math::array_median(array(0.5, 1, 2, 20, 300000)), '', 0.01);
    $this->assertEquals(2, Math::array_median(array(0.5, 20, 300000, 1, 2)), '', 0.01);
  }
  
  
  function testAverage()
  {
    $this->assertEquals(3, Math::array_median(array(1, 2, 3, 4, 5)), '', 0.01);
    $this->assertEquals(20, Math::array_median(array(10, 20, 20, 20, 30)), '', 0.01);
    $this->assertEquals(5, Math::array_median(array(2, 4, 6, 8)), '', 0.01);
  }
  
  
}