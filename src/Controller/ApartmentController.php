<?php

namespace App\Controller;

use App\Entity\Apartment;
use App\Form\ApartmentType;
use App\Repository\ApartmentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/apartment')]
class ApartmentController extends AbstractController
{
    #[Route('/', name: 'app_apartment_index', methods: ['GET'])]
    public function index(ApartmentRepository $apartmentRepository): Response
    {
        return $this->render('apartment/index.html.twig', [
            'apartments' => $apartmentRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_apartment_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ApartmentRepository $apartmentRepository): Response
    {
        $apartment = new Apartment();
        $form = $this->createForm(ApartmentType::class, $apartment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $apartmentRepository->save($apartment, true);

            return $this->redirectToRoute('app_apartment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('apartment/new.html.twig', [
            'apartment' => $apartment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_apartment_show', methods: ['GET'])]
    public function show(Apartment $apartment): Response
    {
        return $this->render('apartment/show.html.twig', [
            'apartment' => $apartment,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_apartment_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Apartment $apartment, ApartmentRepository $apartmentRepository): Response
    {
        $form = $this->createForm(ApartmentType::class, $apartment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $apartmentRepository->save($apartment, true);

            return $this->redirectToRoute('app_apartment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('apartment/edit.html.twig', [
            'apartment' => $apartment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_apartment_delete', methods: ['POST'])]
    public function delete(Request $request, Apartment $apartment, ApartmentRepository $apartmentRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$apartment->getId(), $request->request->get('_token'))) {
            $apartmentRepository->remove($apartment, true);
        }

        return $this->redirectToRoute('app_apartment_index', [], Response::HTTP_SEE_OTHER);
    }
}
