<?php namespace Console;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Console\TransactionModel;

class TransactionCollection extends Command
{

    protected $transactions  =   [];
    
    public function __construct($rows)
    {
        parent::__construct();
        
        $this->set($rows);
    }

    public function set($rows)
    {
        $transactionId = 0;
        foreach($rows as $row) {
            $transaction = new TransactionModel($row);
            $transaction->setTransactionId($transactionId);
            $this->add($transaction);
            $transactionId++;
        }
    }

    public function add($transaction)
    {
        $this->transactions[] = $transaction;
    }

    public function get()
    {
        return $this->transactions;
    }

    public function getByUserId($userId = "")
    {
        $transactions = [];
        foreach($this->transactions as $transaction) {
            if($transaction->getUserId() == $userId) {
                $transactions[] = $transaction;
            }
        }

        return $transactions;
    }

    public function getOpAmountsByUserId($userId = "")
    {
        $operationAmounts = [];
        foreach($this->transactions as $transaction) {
            if($transaction->getUserId() == $userId) {
                $operationAmounts[] = $transaction->getOperationAmount();
            }
        }

        return $operationAmounts;
    }

    public function getByUserIdAndWeek($userId = "", $weekNumber = "", $operationType = "")
    {
        $weekTransactions = [];

        foreach($this->transactions as $transaction) {
            if($transaction->getWeekNumber() == $weekNumber && $transaction->getUserId() == $userId && $transaction->getOperationType() == $operationType) {
                $weekTransactions[] = $transaction;
            }
        }

        return $weekTransactions;
    }

    public function getWithinWeek($transaction)
    {

        $weekTransactions = [];
        
        $date = new \DateTime($transaction->getDate());
        $year = $date->format("Y");

        if($date->format("m") == 12 && $transaction->getWeekNumber() == 01) {
            $year++;
        }

        $dateRange = $this->getWeekRange($transaction->getWeekNumber(), $year);

        foreach($this->transactions as $trans) {

            if($trans->getUserId() == $transaction->getUserId() && $trans->getOperationType() == $transaction->getOperationType()) {

                if($trans->getDate() >= $dateRange['week_start'] && $trans->getDate() <= $dateRange['week_end']) {

                    $weekTransactions[] = $trans;
                }

            }
        }

        return $weekTransactions;
    
    }

    public function getWeekRange($week, $year) {
        $date = new \DateTime();

        $date->setISODate($year, $week);
        $weekRange['week_start'] = $date->format('Y-m-d');
        $date->modify('+6 days');
        $weekRange['week_end'] = $date->format('Y-m-d');

        return $weekRange;
    }


    
}