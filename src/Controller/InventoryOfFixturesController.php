<?php

namespace App\Controller;

use App\Entity\InventoryOfFixtures;
use App\Entity\Rental;
use App\Form\InventoryOfFixturesType;
use App\Repository\InventoryOfFixturesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/inventory/of/fixtures')]
class InventoryOfFixturesController extends AbstractController
{
    #[Route('/', name: 'app_inventory_of_fixtures_index', methods: ['GET'])]
    public function index(InventoryOfFixturesRepository $inventoryOfFixturesRepository): Response
    { 
        // $filtredInventoryOfFixtures = [];
        // $inventoryOfFixtures = $inventoryOfFixturesRepository->findAll();
        // foreach ($inventoryOfFixtures as $inventoryOfFixture) {
        //     if ($inventoryOfFixture->getRental()->getUserAgency()===$this->getUser()){
        //         $filtredInventoryOfFixtures[] = $inventoryOfFixture;
        //     }
        // }
        // return $this->render('inventory_of_fixtures/index.html.twig', [
        //     'inventory_of_fixtures' => $filtredInventoryOfFixtures,
        // ]);
        $inventoryOfFixtures = $inventoryOfFixturesRepository->findByUserAgency($this->getUser());
        return $this->render('inventory_of_fixtures/index.html.twig', [
                'inventory_of_fixtures' => $inventoryOfFixtures,
            ]);
    }


    #[Route('/{id}/new', name: 'app_inventory_of_fixtures_new', methods: ['GET', 'POST'])]
    public function new(Rental $rental, Request $request, InventoryOfFixturesRepository $inventoryOfFixturesRepository): Response
    {
        $inventoryOfFixture = new InventoryOfFixtures();
        //Link inventoryOfFixtues to the rental        
        $inventoryOfFixture->setRental($rental);
        $form = $this->createForm(InventoryOfFixturesType::class, $inventoryOfFixture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $inventoryOfFixturesRepository->save($inventoryOfFixture, true);

            return $this->redirectToRoute('app_inventory_of_fixtures_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('inventory_of_fixtures/new.html.twig', [
            'inventory_of_fixture' => $inventoryOfFixture,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_inventory_of_fixtures_show', methods: ['GET'])]
    public function show(InventoryOfFixtures $inventoryOfFixture): Response
    {
        return $this->render('inventory_of_fixtures/show.html.twig', [
            'inventory_of_fixture' => $inventoryOfFixture,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_inventory_of_fixtures_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, InventoryOfFixtures $inventoryOfFixture, InventoryOfFixturesRepository $inventoryOfFixturesRepository): Response
    {
        $form = $this->createForm(InventoryOfFixturesType::class, $inventoryOfFixture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $inventoryOfFixturesRepository->save($inventoryOfFixture, true);

            return $this->redirectToRoute('app_inventory_of_fixtures_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('inventory_of_fixtures/edit.html.twig', [
            'inventory_of_fixture' => $inventoryOfFixture,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_inventory_of_fixtures_delete', methods: ['POST'])]
    public function delete(Request $request, InventoryOfFixtures $inventoryOfFixture, InventoryOfFixturesRepository $inventoryOfFixturesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$inventoryOfFixture->getId(), $request->request->get('_token'))) {
            $inventoryOfFixturesRepository->remove($inventoryOfFixture, true);
        }

        return $this->redirectToRoute('app_inventory_of_fixtures_index', [], Response::HTTP_SEE_OTHER);
    }
}
