<?php

namespace App\Command;

use App\Repository\LoanRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class OnBookReturnSendMailCommand extends Command
{
    protected static $defaultName = 'onBookReturnSendMail';
    protected static $defaultDescription = 'Add a short description for your command';

    private $loanRepository;

    public function __construct(LoanRepository $loanRepository){
        parent::__construct(null);
        $this->loanRepository = $loanRepository;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $users = $this->loanRepository->getAllUserHavingMoreThanTwoLoans();
        
     
        return 0;
    }
}
