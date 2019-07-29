<?php namespace Console;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Console\TransactionModel;
use Console\BaseComponent;

class Calculator extends BaseComponent
{
    protected $commissions = [];
    protected $transactions;
    
    public function __construct($transactions = [])
    {
        parent::__construct();

        $this->setTransactions($transactions);
        $this->computeCommissions($transactions->get());
    }

    public function setTransactions(&$transactions)
    {
        $this->transactions = $transactions;
    }

    public function getTransactions()
    {
        return $this->transactions;
    }

    public function get()
    {
        return $this->commissions;
    }

    public function computeCommissions($transactions = [])
    {
        foreach($transactions as $transaction) {

            if($transaction->getOperationType() == "cash_in") {
                $commission = $this->computeCashIn($transaction);
                $transaction->setCommissionFee($commission);

                $this->commissions[] = $transaction->getCommissionFee();

            } elseif ($transaction->getOperationType() == "cash_out") {
                $commission = $this->computeCashOut($transaction);
                $transaction->setCommissionFee($commission);

                $this->commissions[] = $transaction->getCommissionFee();
            }

        }
    }

    public function computeCashIn($transaction)
    {
        $commission = number_format($transaction->getOperationAmount() * $this->getCashInFee(), 2);

        if($commission > $this->getCashInLimit()) {
            return $this->getCashInLimit();
        }

        return $commission;
    }

    public function computeCashOut($transaction)
    {
        if($transaction->getUserType() == "natural") {

            return $this->computeNaturalType($transaction);

        } elseif ($transaction->getUserType() == "legal") {

            return $this->computeLegalType($transaction);

        }
    }

    public function computeLegalType($transaction)
    {
        $commission = number_format($transaction->getOperationAmount() * $this->getCashOutFee(), 2);
        if($commission < $this->getCashOutOffset()) {
            return $this->getCashOutOffset();
        }

        return $commission;
    }

    public function computeNaturalType($transaction)
    {
        $exceedAmount = $this->computeExceedAmount($transaction);
        $commission = number_format($exceedAmount * $this->getCashOutFee(), 2);

        return $commission;
    }

    public function computeExceedAmount($transaction)
    {
        $transactions = $this->transactions->getWithinWeek($transaction);
        
        $freeAmount = $this->getFreeCashOutAmount();
        $exceedAmount = 0;
        $weekCount = 1;

        foreach($transactions as $trans) {

            if($weekCount <= 3) {

                if($trans->getOperationAmount() <= $freeAmount) {
                    $freeAmount = $freeAmount - $trans->getOperationAmount();
                    $exceedAmount = 0;

                    if($trans->getTransactionId() == $transaction->getTransactionId()) {
                        return $exceedAmount;
                    }

                } else {
                    $exceedAmount = $trans->getOperationAmount() - $freeAmount;
                    $freeAmount = 0;

                    if($trans->getTransactionId() == $transaction->getTransactionId()) {
                        return $exceedAmount;
                    }
                }

            } else {

                return $transaction->getTransactionId();

            }

            $weekCount++;
        }

        return 0;
    }
    
}