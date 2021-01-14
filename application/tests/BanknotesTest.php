<?php

use \App\Helpers\Banknotes;

class BanknotesTest extends TestCase
{

    public function testValidNotes()
    {
        $this->assertEquals([20], Banknotes::calculator(20));
        $this->assertEquals([20, 20], Banknotes::calculator(40));
        $this->assertEquals([50], Banknotes::calculator(50));
        $this->assertEquals([20, 20, 20], Banknotes::calculator(60));
        $this->assertEquals([50, 20], Banknotes::calculator(70));
        $this->assertEquals([20, 20, 20, 20], Banknotes::calculator(80));
        $this->assertEquals([50, 20, 20], Banknotes::calculator(90));
        $this->assertEquals([100], Banknotes::calculator(100));
        $this->assertEquals([50, 20, 20, 20], Banknotes::calculator(110));
        $this->assertEquals([100, 20], Banknotes::calculator(120));
        $this->assertEquals([50, 20, 20, 20, 20], Banknotes::calculator(130));
        $this->assertEquals([100, 20, 20], Banknotes::calculator(140));
        $this->assertEquals([100, 50], Banknotes::calculator(150));
        $this->assertEquals([100, 20, 20, 20], Banknotes::calculator(160));
        $this->assertEquals([100, 50, 20], Banknotes::calculator(170));
        $this->assertEquals([100, 20, 20, 20, 20], Banknotes::calculator(180));
        $this->assertEquals([100, 50, 20, 20], Banknotes::calculator(190));
        $this->assertEquals([100, 100], Banknotes::calculator(200));
    }

    public function testInvalidNotesOf10()
    {
        $this->expectException(\App\Exceptions\BanknotesException::class);
        Banknotes::calculator(10);
    }


    public function testInvalidNotesOf30()
    {
        $this->expectException(\App\Exceptions\BanknotesException::class);
        Banknotes::calculator(30);
    }

}