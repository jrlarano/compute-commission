<?php namespace Tests\Unit;

use Console\Calculator;
use Console\TransactionCollection;
use Console\TransactionModel;
use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase
{
    public function testComputeCommissions()
    {
        $testCollection = [
            ["2015-01-01",4,"natural","cash_out",1200.00,"EUR"]
        ];
        $transactions = new TransactionCollection($testCollection);
        $calculator = new Calculator();
        $calculator->setTransactions($transactions);
        
        //test computeCommission method
        $calculator->computeCommissions($transactions->get());

        $results = $calculator->get();

        $this->assertEquals(0.60, $results[0]->getCommissionFee());
    }

    public function testComputeCashIn()
    {
        $testCollection = ["2016-01-05",1,"natural","cash_in",200.00,"EUR"];
        $transaction = new TransactionModel($testCollection);
        $calculator = new Calculator();

        $result = $calculator->computeCashIn($transaction);

        $this->assertEquals(0.06, $result);
    }

    public function testComputeCashOut()
    {
        $testCollection = [
            ["2015-01-01",4,"natural","cash_out",1200.00,"EUR"]
        ];
        $transactions = new TransactionCollection($testCollection);
        $calculator = new Calculator();
        $calculator->setTransactions($transactions);
        
        //test computeCashOut method
        $result = $calculator->computeCashOut($transactions->get()[0]);

        $this->assertEquals(0.60, $result);
    }

    public function testComputeLegalType()
    {
        $testCollection = ["2016-01-05",1,"natural","cash_in",300.00,"EUR"];
        $transaction = new TransactionModel($testCollection);
        $calculator = new Calculator();

        //test computeLegalType method
        $result = $calculator->computeLegalType($transaction);

        $this->assertEquals(0.90, $result);
    }

    public function testComputeNaturalType()
    {
        $testCollection = [
            ["2015-01-01",4,"natural","cash_out",1200.00,"EUR"]
        ];
        $transactions = new TransactionCollection($testCollection);
        $calculator = new Calculator();
        $calculator->setTransactions($transactions);
        
        //test computeNaturalType method
        $result = $calculator->computeNaturalType($transactions->get()[0]);

        $this->assertEquals(0.60, $result);
    }

    public function testComputeExceedAmount()
    {
        $testCollection = [
            ["2015-01-01",4,"natural","cash_out",200.00,"EUR"],
            ["2015-01-01",4,"natural","cash_out",1200.00,"EUR"],
            ["2015-01-01",4,"natural","cash_out",1200.00,"EUR"]
        ];
        $transactions = new TransactionCollection($testCollection);
        $calculator = new Calculator();
        $calculator->setTransactions($transactions);
        
        //test computeNaturalType method
        $result1 = $calculator->computeExceedAmount($transactions->get()[0]);
        $result2 = $calculator->computeExceedAmount($transactions->get()[1]);
        $result3 = $calculator->computeExceedAmount($transactions->get()[2]);

        $this->assertEquals(0, $result1);
        $this->assertEquals(400, $result2);
        $this->assertEquals(1200, $result3);
    }

}