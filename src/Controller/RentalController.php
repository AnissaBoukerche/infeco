<?php

namespace App\Controller;

use App\Entity\Rental;
use App\Entity\RentalReceipts;
use App\Form\RentalReceiptsType;
use App\Form\RentalType;
use App\Repository\InventoryOfFixturesRepository;
use App\Repository\PaymentRepository;
use App\Repository\RentalReceiptsRepository;
use App\Repository\RentalRepository;
use App\Repository\TenantRepository;
use App\Service\MailerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/rental')]
class RentalController extends AbstractController
{
    #[Route('/', name: 'app_rental_index', methods: ['GET'])]
    public function index(RentalRepository $rentalRepository): Response
    {
        $rental = $rentalRepository->findByUserAgency($this->getUser());
        return $this->render('rental/index.html.twig', [
                'rentals' => $rental,
            ]);
    }

    #[Route('/new', name: 'app_rental_new', methods: ['GET', 'POST'])]
    public function new(Request $request, RentalRepository $rentalRepository): Response
    {
        $rental = new Rental();
        $form = $this->createForm(RentalType::class, $rental);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $rentalRepository->save($rental, true);

            return $this->redirectToRoute('app_rental_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('rental/new.html.twig', [
            'rental' => $rental,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_rental_show', methods: ['GET'])]
    public function show(Rental $rental, TenantRepository $tenantRepository, InventoryOfFixturesRepository $inventoryOfFixturesRepository, PaymentRepository $paymentRepository, RentalReceiptsRepository $rentalReceiptsRepository): Response
    {
         // Fetch related entities
        $tenants = $tenantRepository->findByRental($rental);
        $inventoryOfFixtures = $inventoryOfFixturesRepository->findByRental($rental);
        $payments = $paymentRepository->findByRental($rental);
        $rentalReceipts = $rentalReceiptsRepository->findByRental($rental);

        // Calculate the total for the rental : rent + charges + fees * duration in months
        $totalAmount = $rental->calculateTotalAmount();
        // Calculate the total for the rental at exit : rent + charges + fees * total duration in months
        $totalAmountAtExit = $rental->calculateTotalAmountAtExit();
        // Calculate the rent balance
        $rentBalance = $rental->calculateRentBalance();


        // Render the template with the fetched entities and calculated payments
        return $this->render('rental/show.html.twig', [
            'rental' => $rental,
            'total_amount' => $totalAmount,
            'total_amount_at_exit' => $totalAmountAtExit,
            'rent_balance' => $rentBalance,
            'tenants' => $tenants,
            'inventory_of_fixtures' => $inventoryOfFixtures,
            'payments' => $payments,
            'rental_receipts' => $rentalReceipts,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_rental_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Rental $rental, RentalRepository $rentalRepository): Response
    {
        $form = $this->createForm(RentalType::class, $rental);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $rentalRepository->save($rental, true);

            return $this->redirectToRoute('app_rental_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('rental/edit.html.twig', [
            'rental' => $rental,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_rental_delete', methods: ['POST'])]
    public function delete(Request $request, Rental $rental, RentalRepository $rentalRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rental->getId(), $request->request->get('_token'))) {
            $rentalRepository->remove($rental, true);
        }

        return $this->redirectToRoute('app_rental_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/receipts', name: 'app_rental_receipts', methods: ['GET', 'POST'])]
    public function rentalReceipts(Request $request,
    Rental $rental, 
    PaymentRepository $paymentRepository, 
    RentalReceiptsRepository $rentalReceiptsRepository, 
    EntityManagerInterface $entityManager,
    MailerService $mailer,
    ): Response
    {
        // Create a form to collect the dates for the receipts
        $form = $this->createForm(RentalReceiptsType::class);
        $form->handleRequest($request);
        // Fetch related entity
        $rentalReceipts = $rentalReceiptsRepository->findByRental($rental);
        $paymentsWithoutReceipts = $paymentRepository->findPaymentsWithoutRentalReceipts();
        // Initialize the $balance
        $balance = null;
        //Check if the form is submitted and valid
        if ($form->isSubmitted() && $form->isValid()) {
            // Get the dates from the form
            $startAt = $form->get('startAt')->getData();
            $endAt = $form->get('endAt')->getData();
            // Calculate the number of months between the start and end date and the total amount
            $payments = $paymentRepository->findPaymentsBetweenDates($rental, $startAt, $endAt);
            //Link the payments to the receipts
            $rentalReceipts = new RentalReceipts();
            foreach($payments as $payment) {
                $rentalReceipts->addPayment($payment);
            }
            $rentalReceipts->setStartAt($startAt);
            $rentalReceipts->setEndAt($endAt);
            $rentalReceipts->setRentAmount($rental->getRent());
            $rentalReceipts->setChargesAmount($rental->getCharges());
            $rentalReceipts->setAgencyFeesAmount($rentalReceipts->calculateAgencyFeesOnRent());
            $rentalReceipts->setTotalAmount($rentalReceipts->calculateTotalAmount());
            // Calculate the balance
            $balance = $rentalReceipts->calculateRentBalance();
            $rentalReceipts->setBalance($balance);
            // Check if the balance is positive
            if ($balance > 0) {
                $entityManager->persist($rentalReceipts);
                $entityManager->flush();
            // Render the template with the fetched entity and calculated payments
            $response = $this->redirectToRoute('app_rental_show', [
                'id' => $rental->getId(),
            ]);
            // Send the rental receipts by email
            $mailer->sendRentalReceiptsEmail($rental, $rentalReceiptsRepository);
            $this->addFlash('success', 'Email envoyé avec succès!');
            return $response;
            } else {
                // Redirect to the rental index page with an error message
                $this->addFlash('error', 'Le solde est négatif, vous ne pouvez pas générer une quittance.');
                return $this->redirectToRoute('app_rental_index', [], Response::HTTP_SEE_OTHER);
            }
        }
        return $this->render('rental/receipts/form.html.twig', [
            'form' => $form->createView(),
            'rental' => $rental,
            'rental_receipts' => $rentalReceipts,
            'payments_without_receipts' => $paymentsWithoutReceipts,
            'balance' => $balance,
        ]);


    }
}