<?php

namespace App\EventSubscriber;

use App\Event\SendMailEvent;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class SendEmailSubscriber implements EventSubscriberInterface
{
    private  $entityManager;
    private  $logger;
    private  $mailer;

    public function __construct(EntityManagerInterface $entityManager, LoggerInterface $logger, MailerInterface $mailer)
    {
        $this->entityManager = $entityManager;
        $this->logger = $logger;
        $this->mailer = $mailer;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            SendMailEvent::SEND_EMAIL => 'sendEmail',
        ];
    }

    public function sendEmail(SendMailEvent $event): void
    {
        $user = $event->getUser();


        $email = (new Email())
            ->from(new Address('specialagent0601@gmail.com', 'The Space Bar'))
            ->to(new Address($user->getEmail()))
            ->subject('Reminder: Overdue Book Submission')
            ->text('You have to submit the book that you took 25 days ago so please take not of it.');
        $this->mailer->send($email);
    }
}
