<?php
// tests/Sample/CalculateTest.php

namespace App\Tests\Sample;

use App\Sample\Calculate;
use PHPUnit\Framework\TestCase;

class CalculateTest extends TestCase
{

    public function testCalcul()
    {
        $calculator = new Calculate();
        $result = $calculator->calcul(30, 12);
        $this->assertEquals(42, $result);
    }
    
}
