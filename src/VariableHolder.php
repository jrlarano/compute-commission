<?php namespace Console;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Console\TransactionModel;

class VariableHolder extends Command
{

    protected $csvRow  =   [];
    protected $freeAmount = 1000;
    
    public function __construct()
    {
        parent::__construct();
    }

    public function getCsvRow()
    {
        return $this->csvRow;
    }

    public function insertRowToCsvRow($row = [])
    {
        // $this->csvRow[] = $this->mapRowToCsvArr($row);
        $this->csvRow[] = new TransactionModel($row);
    }

    public function computeExceedAmout($row)
    {
        $rowArr = new TransactionModel($row);
        $opAmounts = [];
        $freeAmount = $this->freeAmount;

        foreach($this->csvRow as $row) {
            if($row->getUserId() == $rowArr['user_id']) {
                $opAmounts[] = $row->getOperationAmount();
            }
        }

        $totalAmount = array_sum($opAmounts);
        $exceedAmount = $totalAmount - $this->freeAmount;

        if($totalAmount <= $this->freeAmount) {
            return 0;
        } elseif($exceedAmount >= $rowArr['op_amount']) {
            return $rowArr['op_amount'];
        } else {
            return $exceedAmount;
        }
    }

    public function isWithinWeek($row)
    {
        //bool if within week (monday-sunday)
    }


    
}