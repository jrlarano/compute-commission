<?php namespace Console;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class BaseComponent extends SymfonyCommand
{

    protected $cashInFee  =   "";
    protected $cashOutFee =   "";
    
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

    public function setCashOutFee($percentageFee = 0)
    {
        $this->cashOutFee = $this->getPercentToDecimal($percentageFee);
    }

    public function getCashInFee()
    {
        return $this->cashInFee;
    }

    public function getCashOutFee()
    {
        return $this->cashOutFee;
    }

    public function getPercentToDecimal($percent = 0)
    {
        return $percent/100;
    }

    public function computeCommissionByExceed($exceed, $opType)
    {
        if($opType == 'cash_in') {
            $fee = $this->getCashInFee();
        } else {
            $fee = $this->getCashOutFee();
        }
        return $exceed * $fee;
    }

    
}