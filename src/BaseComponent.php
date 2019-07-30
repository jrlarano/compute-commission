<?php namespace Console;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
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

class BaseComponent extends SymfonyCommand
{
    //These variables act as config variables for now
    protected $cashInFee        =   "";
    protected $cashOutFee       =   "";
    protected $freeCashOutAmount= 1000;
    protected $cashInLimit      = 5.00;
    protected $cashOutOffset    = 0.50;
    protected $currencyEur      = 1;
    protected $currencyUsd      = 1.1497;
    protected $currencyJpy      = 129.53;
    
    public function __construct()
    {
        parent::__construct();

        $this->setCashInFee(0.03);
        $this->SetCashOutFee(0.3);
        
    }

    public function setCashInFee($percentageFee = 0)
    {
        $this->cashInFee = $this->getPercentToDecimal($percentageFee);
    }

    public function getCashInFee()
    {
        return $this->cashInFee;
    }

    public function setCashOutFee($percentageFee = 0)
    {
        $this->cashOutFee = $this->getPercentToDecimal($percentageFee);
    }

    public function getCashOutFee()
    {
        return $this->cashOutFee;
    }

    public function setFreeCashOutAmount($freeCashOutAmount)
    {
        $this->freeCashOutAmount = $freeCashOutAmount;
    }

    public function getFreeCashOutAmount()
    {
        return $this->freeCashOutAmount;
    }

    public function setCashInLimit($cashInLimit = 0)
    {
        $this->cashInLimit = $cashInLimit;
    }

    public function getCashInLimit()
    {
        return number_format($this->cashInLimit, 2);
    }

    public function setCashOutOffset($cashOutOffset = 0)
    {
        $this->cashOutOffset = $cashOutOffset;
    }

    public function getCashOutOffset()
    {
        return number_format($this->cashOutOffset, 2);
    }

    public function getPercentToDecimal($percent = 0)
    {
        return $percent/100;
    }

    public function getConvertedCurrency($amount = "0", $currency = "EUR")
    {
        if($currency == "JPY") {
            return $amount / $this->currencyJpy;
        } elseif($currency == "USD") {
            return $amount / $this->currencyUsd;
        } else {
            return $amount;
        }
    }

    
}