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

/**
* Calculator Class document comment here
*
* @author   Jevy Larano <jevyroque@gmail.com>
*
*/

class CommissionController extends BaseComponent
{
    
    protected $csvFolderPath = __DIR__ . '/../../public/csv/';

    public function configure()
    {
        $this -> setName('compute-commission')
            -> setDescription('Compute commission for Cash-in and Cash-out')
            -> setHelp('This command allows you to compute commission from CSV file.')
            -> addArgument('csvName', InputArgument::REQUIRED, 'CSV file located at ' . $this->getPublicPath());
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $csvName = $input->getArgument('csvName');
        $csvInputs = [];

        $csvFullPath = $this->getPublicPath() . $csvName;

        $csvInputs = $this->readFileToArray($csvFullPath);

        $transactions = new TransactionCollection($csvInputs);

        $calculator = new Calculator($transactions);

        foreach($calculator->get() as $transaction) {
            $output->writeln($transaction->getCommissionFee());
        }
    }

    private function getPublicPath()
    {
        return str_replace("src/Controller/../../", "", $this->csvFolderPath);
    }

    private function readFileToArray($fullPath)
    {
        try{
            $csvInputs = [];
            $file = fopen($fullPath,"r");

            if($file) {

                while(!feof($file)) {
                    $csvInputs[] = fgetcsv($file);
                }

                fclose($file);
            }

            return $csvInputs;

        } catch (Exception $e) {
            echo 'Caught exception: '.  $e->getMessage() . "\n";
        }
    }

}