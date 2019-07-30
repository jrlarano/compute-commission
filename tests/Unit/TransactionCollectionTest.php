<?php namespace Tests\Unit;

use Console\Calculator;
use Console\TransactionCollection;
use Console\TransactionModel;
use PHPUnit\Framework\TestCase;

class TransactionCollectionTest extends TestCase
{
    public function testGetByUserId()
    {
        $testCollection = [
            ["2015-01-01",4,"natural","cash_out",1200.00,"EUR"],
            ["2015-01-01",1,"natural","cash_out",1200.00,"EUR"],
            ["2015-01-01",1,"natural","cash_out",1200.00,"EUR"],
        ];
        $transactions = new TransactionCollection($testCollection);
        
        $results = $transactions->getByUserId(1);


        $this->assertEquals(2, count($results));
    }

    public function testGetOpAmountsByUserId()
    {
        $testCollection = [
            ["2014-12-31",4,"natural","cash_out",1200.00,"EUR"],
            ["2015-01-01",4,"natural","cash_out",1200.00,"EUR"],
            ["2016-01-05",4,"natural","cash_out",1200.00,"EUR"],
            ["2015-01-01",1,"natural","cash_out",1200.00,"EUR"],
            ["2015-01-01",1,"natural","cash_out",1200.00,"EUR"],
        ];
        $transactions = new TransactionCollection($testCollection);
        
        $results = $transactions->getOpAmountsByUserId(1);


        $this->assertEquals(2400.00, array_sum($results));
    }

    public function testGetWithinWeek()
    {
        $testCollection = [
            ["2014-12-31",4,"natural","cash_out",1200.00,"EUR"],
            ["2015-01-01",4,"natural","cash_out",1200.00,"EUR"],
            ["2016-01-05",4,"natural","cash_out",1200.00,"EUR"],
        ];
        $transactions = new TransactionCollection($testCollection);
        
        $results = $transactions->getWithinWeek($transactions->get()[0]);

        $this->assertEquals(2, count($results));
    }


}