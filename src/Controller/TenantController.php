<?php

namespace App\Controller;

use App\Entity\Rental;
use App\Entity\Tenant;
use App\Form\TenantType;
use App\Repository\TenantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/tenant')]
class TenantController extends AbstractController
{
    #[Route('/', name: 'app_tenant_index', methods: ['GET'])]
    public function index(TenantRepository $tenantRepository): Response
    {
        //Retrieve all tenants associated with the logged-in user
        $tenant = $tenantRepository->findByUserAgency($this->getUser());
        return $this->render('tenant/index.html.twig', [
            'tenants' => $tenant,
            ]);
    }
    //Add id to link tenant to the rental  
    #[Route('/{id}/new', name: 'app_tenant_new', methods: ['GET', 'POST'])]
    //Add entity rental to link tenant to the rental  
    public function new(Rental $rental, Request $request, TenantRepository $tenantRepository): Response
    {
        $tenant = new Tenant();
        //Link tenant to the rental        
        $tenant->addRental($rental);
        $form = $this->createForm(TenantType::class, $tenant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tenantRepository->save($tenant, true);

            return $this->redirectToRoute('app_tenant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tenant/new.html.twig', [
            'tenant' => $tenant,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_tenant_show', methods: ['GET'])]
    public function show(Tenant $tenant): Response
    {
        return $this->render('tenant/show.html.twig', [
            'tenant' => $tenant,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_tenant_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Tenant $tenant, TenantRepository $tenantRepository): Response
    {
        $form = $this->createForm(TenantType::class, $tenant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tenantRepository->save($tenant, true);

            return $this->redirectToRoute('app_tenant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tenant/edit.html.twig', [
            'tenant' => $tenant,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_tenant_delete', methods: ['POST'])]
    public function delete(Request $request, Tenant $tenant, TenantRepository $tenantRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tenant->getId(), $request->request->get('_token'))) {
            $tenantRepository->remove($tenant, true);
        }

        return $this->redirectToRoute('app_tenant_index', [], Response::HTTP_SEE_OTHER);
    }
}
