<?php namespace Console\Controller;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Console\ComputeCommission;
use Console\VariableHolder;
use Console\BaseComponent;
use Console\TransactionCollection;
use Console\Calculator;

class CommissionController extends BaseComponent
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
        // $output->writeln(["This is the CSV path", $input->getArgument('csvPath')]);
        
        $sampleData = $this->sampleData();

        $transactions = new TransactionCollection($sampleData);

        $calculator = new Calculator($transactions);

        // print_r($calculator->get());
        foreach($calculator->get() as $commissionFee) {
            $output->writeln($commissionFee);
        }

    }

    private function sampleData()
    {
        return $sampleData = [
            ["2014-12-31",4,"natural","cash_out",1200,"EUR"  ],
            ["2015-01-01",4,"natural","cash_out",1000,"EUR"  ],
            ["2016-01-05",4,"natural","cash_out",1000,"EUR"  ],
            ["2016-01-05",1,"natural","cash_in",200,"EUR"  ],
            ["2016-01-06",2,"legal","cash_out",300,"EUR"  ],
            ["2016-01-06",1,"natural","cash_out",30000,"JPY"  ],
            ["2016-01-07",1,"natural","cash_out",1000,"EUR"  ],
            ["2016-01-07",1,"natural","cash_out",100,"USD"  ],
            ["2016-01-10",1,"natural","cash_out",100,"EUR"  ],
            ["2016-01-10",2,"legal","cash_in",1000000,"EUR"  ],
            ["2016-01-10",3,"natural","cash_out",1000,"EUR"  ],
            ["2016-02-15",1,"natural","cash_out",300,"EUR"  ],
            ["2016-02-19",5,"natural","cash_out",3000000,"JPY"  ],
        ];

    }
}