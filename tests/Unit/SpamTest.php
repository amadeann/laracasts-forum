<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Inspections\Spam;

class SpamTest extends TestCase
{
    public function testItChecksForInvalidKeywords()
    {
        $spam = new Spam();

        $this->assertFalse($spam->detect('Innocent reply here.'));

        $this->expectException('Exception');

        $spam->detect('yahoo customer support');
    }

    public function testItChecksForAnyKeyBeingHeldDown()
    {
        $spam = new Spam();

        $this->expectException('Exception');

        $spam->detect('Hello World aaaaaaaaaaaa!');
    }
}
