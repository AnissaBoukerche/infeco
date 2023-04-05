<?php

namespace App\Controller;

use App\Entity\Rental;
use App\Form\RentalType;
use App\Repository\InventoryOfFixturesRepository;
use App\Repository\PaymentRepository;
use App\Repository\RentalRepository;
use App\Repository\TenantRepository;
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
        return $this->render('rental/index.html.twig', [
            'rentals' => $rentalRepository->findAll(),
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
    public function show(Rental $rental, TenantRepository $tenantRepository, InventoryOfFixturesRepository $inventoryOfFixturesRepository, PaymentRepository $paymentRepository): Response
    {
         // Fetch related entities
        $tenants = $tenantRepository->findByRental($rental);
        $inventoryOfFixtures = $inventoryOfFixturesRepository->findByRental($rental);
        $payments = $paymentRepository->findByRental($rental);

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
}
