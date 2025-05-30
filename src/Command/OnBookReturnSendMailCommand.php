<?php

namespace App\Command;

use App\Event\SendMailEvent;
use App\Repository\LoanRepository;
use App\Repository\UserRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class OnBookReturnSendMailCommand extends Command
{
    protected static $defaultName = 'onBookReturnSendMail';
    protected static $defaultDescription = 'Send warning email to users with more than two overdue loans';

    private UserRepository $userRepository;
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(UserRepository $userRepository, EventDispatcherInterface $eventDispatcher)
    {
        parent::__construct();
        $this->userRepository = $userRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $users = $this->userRepository->getAllUserHavingMoreThanTwoLoans();

        foreach ($users as $user) {
            $this->eventDispatcher->dispatch(new SendMailEvent($user), SendMailEvent::SEND_EMAIL);
        }

        
        $io->success('Warning emails sent successfully.');

        return Command::SUCCESS;
    }
}
