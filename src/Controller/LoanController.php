<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Loan;
use App\Form\LoanType;
use App\Repository\BookRepository;
use App\Repository\LoanRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/loan")
 */
class LoanController extends AbstractController
{
    /**
     * @Route("/", name="app_loan_index", methods={"GET"})
     */
    public function index(LoanRepository $loanRepository): Response
    {
        return $this->render('loan/index.html.twig', [
            'loans' => $loanRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/{bookid}", name="app_borrow_book", methods={"GET", "POST"})
     */
    public function newLoan(
        int $bookid,
        BookRepository $bookRepository,
        UserRepository $userRepository,
        LoanRepository $loanRepository,
        EntityManager $entityManager
    ): Response {

        $book = $bookRepository->find($bookid);
        $user = $this->getUser();

        if (!$book || !$user || !$book->isIsAvailable()) {
            $this->addFlash('danger', 'Invalid book or user, or book is already loaned.');
            return $this->redirectToRoute('app_book_index');
        }


        $loan = new Loan();
        $loan->setBook($book);
        $loan->setUsers($user);
        $loan->setLoanedAt(new \DateTimeImmutable());
        $loan->setDueAt((new \DateTimeImmutable())->modify('+14 days'));
        $book->setIsAvailable(false);

        $entityManager->persist($loan);
        $entityManager->flush();



        return $this->redirectToRoute('app_loan_index');
    }

    /**
     * @Route("/{id}", name="app_loan_show", methods={"GET"})
     */
    public function show(Loan $loan): Response
    {
        return $this->render('loan/show.html.twig', [
            'loan' => $loan,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_loan_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Loan $loan, LoanRepository $loanRepository): Response
    {
        $form = $this->createForm(LoanType::class, $loan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $loanRepository->add($loan, true);

            return $this->redirectToRoute('app_loan_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('loan/edit.html.twig', [
            'loan' => $loan,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/return-book/{bookid}", name="app_loan_return", methods={"POST"})
     */
    public function returnbook(int $bookid, BookRepository $bookRepository, LoanRepository $loanRepository,EntityManagerInterface $entityManager): Response
    {

        $book = $bookRepository->find($bookid);

        if (!$book) {
            $this->addFlash('danger', 'Book not found.');
            return $this->redirectToRoute('app_book_index');
        }


        $loan = $loanRepository->findOneBy([
            'book' => $book,
            'user' => $this->getUser(),
            'returnedAt' => null,
        ]);


        if (!$loan) {
            $this->addFlash('danger', 'This book has not been borrowed by you or it has already been returned.');
            return $this->redirectToRoute('app_book_index');
        }


        $book->setIsAvailable(true);

        $loan->setReturnedAt(new \DateTimeImmutable());

        $entityManager->persist($loan,$book);
        $entityManager->flush();

        $this->addFlash('success', 'Book returned successfully.');

        return $this->redirectToRoute('app_loan_index');
    }
}
