<?php

namespace App\EventSubscriber;
 
use App\Event\LoanReturnedEvent;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class LoanReturnSubscriber implements EventSubscriberInterface
{ 
    private EntityManagerInterface $entityManager;
    private LoggerInterface $loggerInterface;

    public function __construct(EntityManagerInterface $entityManager,LoggerInterface $loggerInterface){
        $this->entityManager =$entityManager;
        $this->loggerInterface = $loggerInterface;
    
    }
    public static function getSubscribedEvents(){
        return[
            LoanReturnedEvent::LOAN_RETURNED => 'onLoanReturned'
        ];
    }
    public function onLoanReturned(LoanReturnedEvent $event)
    {
        $loan = $event->getLoan();
        $loan->setReturnedAt(new \DateTimeImmutable());
        $loan->getBook()->setIsAvailable(true);
        $this->entityManager->flush();
        $this->loggerInterface->info("The loan #{$loan->getId()} has been returned.");
    }
}