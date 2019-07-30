<?php namespace Console;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
* Calculator Class document comment here
*
* @author   Jevy Larano <jevyroque@gmail.com>
*
*/

class TransactionModel extends Command
{
    protected $transactionId;
    protected $date;
    protected $userId;
    protected $userType;
    protected $operationType;
    protected $operationAmount;
    protected $operationCurrency;
    protected $weekNumber;
    protected $commissionFee;
    
    public function __construct($row = [])
    {
        parent::__construct();

        if(!empty($row)) {
            $this->set($row);
        }
    }

    public function set($row)
    {
        $this->setDate($row[0]);
        $this->setWeekNumber($row[0]);
        $this->setUserId($row[1]);
        $this->setUserType($row[2]);
        $this->setOperationType($row[3]);
        $this->setOperationAmount($row[4]);
        $this->setOperationCurrency($row[5]);
    }

    public function get()
    {
        return $this;
    }

    public function setTransactionId($transactionId)
    {
        $this->transactionId = $transactionId;
    }

    public function getTransactionId()
    {
        return $this->transactionId;
    }

    public function setDate($date = "")
    {
        $this->date = $date;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setWeekNumber($date = "")
    {
        $weekDate = date("W", strtotime($date));
        $this->weekNumber = $weekDate;
    }

    public function getWeekNumber()
    {
        return $this->weekNumber;
    }

    public function setUserId($userId = "")
    {
        $this->userId = $userId;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setUserType($userType = "")
    {
        $this->userType = $userType;
    }

    public function getUserType()
    {
        return $this->userType;
    }

    public function setOperationType($operationType = "")
    {
        $this->operationType = $operationType;
    }

    public function getOperationType()
    {
        return $this->operationType;
    }

    public function setOperationAmount($operationAmount = "")
    {
        $this->operationAmount = $operationAmount;
    }

    public function getOperationAmount()
    {
        return $this->operationAmount;
    }

    public function setOperationCurrency($operationCurrency = "")
    {
        $this->operationCurrency = $operationCurrency;
    }

    public function getOperationCurrency()
    {
        return $this->operationCurrency;
    }

    public function setCommissionFee($commissionFee = "")
    {
        $this->commissionFee = $commissionFee;
    }

    public function getCommissionFee()
    {
        return $this->commissionFee;
    }


    
}