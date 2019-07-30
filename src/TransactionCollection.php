<?php namespace Console;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Console\TransactionModel;

/**
* Calculator Class document comment here
*
* @author   Jevy Larano <jevyroque@gmail.com>
*
*/

class TransactionCollection extends Command
{
    protected $transactions  =   [];
    
    /**
     * __construct
     * 
     * @param {array} csv $rows
     *
     * @returns void
     */
    public function __construct($rows = [])
    {
        parent::__construct();
        
        $this->set($rows);
    }

    /**
     * set
     * 
     * @param {array} csv $rows
     *
     * @returns void
     */
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

    /**
     * add
     * 
     * @param {TransactionModel} csv $transaction
     *
     * @returns void
     */
    public function add($transaction)
    {
        $this->transactions[] = $transaction;
    }

    /**
     * get
     *
     * @returns array of objects
     */
    public function get()
    {
        return $this->transactions;
    }

    /**
     * getByUserId
     * 
     * @param {str} $userId
     *
     * @returns array of objects {TransactionCollection}
     */
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

    /**
    * getOpAmountsByUserId
    * 
    * @param {str} $userId
    *
    * @returns array of int
    */
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

    /**
    * getWithinWeek
    * 
    * @param {TransactionModel} $transaction
    *
    * @returns array of Objects
    */
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

    /**
    * getWeekRange
    * 
    * @param {int, int} $week, $year
    *
    * @returns array of Int
    */
    private function getWeekRange($week, $year) {
        $date = new \DateTime();

        $date->setISODate($year, $week);
        $weekRange['week_start'] = $date->format('Y-m-d');
        $date->modify('+6 days');
        $weekRange['week_end'] = $date->format('Y-m-d');

        return $weekRange;
    }


    
}