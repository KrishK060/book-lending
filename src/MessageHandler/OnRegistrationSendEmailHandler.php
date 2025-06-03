<?php
namespace App\MessageHandler;

use App\Message\OnRegistrationSendEmail;
use App\Message\OnRegistrationSendEmail as MessageOnRegistrationSendEmail;
use Doctrine\ORM\Persisters\Collection\OneToManyPersister;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Messenger\MessageHandler;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class OnRegistrationSendEmailHandler implements MessageHandlerInterface{
    private $mailer;

    public function __construct(MailerInterface $mailer){
        $this->mailer = $mailer;
    }
    
    public function __invoke(OnRegistrationSendEmail $event){
        $user = $event->getUser();

        $email = (new Email())
        
            ->from(new Address('specialagent0601@gmail.com', 'The Space Bar'))
            ->to(new Address($user->getEmail()))
            ->subject('congratulations:on registration')
            ->text('You have to been succesfully registerd on website');
        $this->mailer->send($email);
    }

}