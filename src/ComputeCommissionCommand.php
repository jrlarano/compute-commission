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
        $output->writeln(["This is the exceed amount", $this->sampleData()]);
    }

    private function sampleData()
    {
        $sampleData = [
            [
                "2014-12-31",
                "4",
                "natural",
                "cash_out",
                "1200.00",
                "EUR"
            ],
            [
                "2014-12-31",
                "4",
                "natural",
                "cash_out",
                "1200.00",
                "EUR"
            ]
        ];

        $variableHolder = new VariableHolder();

        $exceedAmount = [];
        foreach($sampleData as $row) {
            $exceedAmount[] = $variableHolder->computeExceedAmout($row);
        }
        return array_sum($exceedAmount);
        // return $variableHolder->computeExceedAmout($sampleData);

    }
}