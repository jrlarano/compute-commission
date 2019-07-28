<?php namespace Console;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

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
        $this->csvRow[] = $this->mapRowToCsvArr($row);
    }

    public function computeExceedAmout($row)
    {
        $rowArr = $this->mapRowToCsvArr($row);
        $opAmounts = [];
        $freeAmount = $this->freeAmount;

        foreach($this->csvRow as $row) {
            if($row['user_id'] == $rowArr['user_id']) {
                $opAmounts[] = $row['op_amount'];
            }
        }

        $totalAmount = array_sum($opAmounts) + $rowArr['op_amount'];

        if($totalAmount <= $this->freeAmount) {
            return 0;
        } else {
            return $totalAmount - $this->freeAmount;
        }
    }

    private function isWithinWeek($row)
    {
        //bool if within week (monday-sunday)
    }

    private function mapRowToCsvArr($row)
    {
        return [
            'date'      =>  $row[0],
            'user_id'   =>  $row[1],
            'user_type' =>  $row[2],
            'op_type'   =>  $row[3],
            'op_amount' =>  $row[4],
            'op_currency'=> $row[5]
        ];
    }


    
}