<?php namespace Console;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Console\ComputeCommission;
use Console\VariableHolder;

class ComputeCommissionCommand extends Command
{
    
    public function configure()
    {
        $this -> setName('compute-commission')
            -> setDescription('Compute commission for Cash-in and Cash-out')
            -> setHelp('This command allows you to compute commission from CSV file.')
            -> addArgument('csvPath', InputArgument::REQUIRED, 'The path of CSV file');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        // $this -> greetUser($input, $output);
        $output->writeln(["This is the CSV path", $input->getArgument('csvPath')]);
        // $output->writeln(["This is the exceed amount", $this->sampleData()]);
        $this->sampleData();
    }

    private function sampleData()
    {
        $sampleData = [
            [
                "2014-12-31",
                "4",
                "natural",
                "cash_out",
                "200.00",
                "EUR"
            ],
            [
                "2014-12-31",
                "4",
                "natural",
                "cash_out",
                "1300.00",
                "EUR"
            ],
            [
                "2014-12-31",
                "1",
                "natural",
                "cash_out",
                "1300.00",
                "EUR"
            ],
        ];

        $variableHolder = new VariableHolder();

        $exceedAmount = [];
        echo count($sampleData) . "\n";
        foreach($sampleData as $row) {
            print_r($row) . "\n";
            $variableHolder->insertRowToCsvRow($row);
            $exceedAmount[] = $variableHolder->computeExceedAmout($row);

            echo "This is the exceeded amount: " . $variableHolder->computeExceedAmout($row) . "\n";
        }
        // return array_sum($exceedAmount);
        // return $variableHolder->computeExceedAmout($sampleData);

    }
}