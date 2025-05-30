<?php

namespace App\Controller;

use App\Repository\LoanRepository;
use App\Repository\UserRepository;
use PharIo\Manifest\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email as MimeEmail;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     */
    public function index(
        UserRepository $loanRepository,
        MailerInterface $mailer
    ): Response
    {
        $users = $loanRepository->getAllUserHavingMoreThanTwoLoans();
        
        foreach($users as $user){

            dump($user);
            // $email =(new MimeEmail())
            // ->from(new Address('alienmailer@example.com','the space bar'))
            // ->to(new Address($user->getEmail(),$user->getFirstName()))
            // ->subject('welcome to space bar')
            // ->text('uyuyfuy');
        
            //  $mailer->send($email);
        }

        return $this->render('homepage/index.html.twig');
    }
}
