<?php

namespace App\Controller;

use App\Repository\LoanRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     */
    public function index(UserRepository $loanRepository, MailerInterface $mailer): Response
    {
       
        // $users = $loanRepository->getAllUserHavingMoreThanTwoLoans();
        // foreach ($users as $user) {
        //     // dd($user);
        //     $email = (new Email())
        //         ->from(new Address('alienmailer@example.com', 'The Space Bar'))
        //         ->to(new Address($user->getEmail()))
        //         ->subject('Reminder: Overdue Book Submission')
        //         ->text('You have to submit the book that you took 25 days ago.');

        //     $mailer->send($email);
        // }

        return $this->render('homepage/index.html.twig');
    }
}
