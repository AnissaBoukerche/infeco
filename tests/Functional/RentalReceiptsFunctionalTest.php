<?php

namespace App\Tests\Functional;

use App\Entity\Rental;
use App\Entity\UserAgency;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;


class RentalReceiptsFunctionalTest extends WebTestCase
{
    public function testIfCreateRentalReceiptsIsSuccessfull(): void
    {
        $client = static::createClient();
        //Get the urlgenerator
        $urlGenerator = $client->getContainer()->get('router');

        //Get the entity manager
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');
        
        $userAgency = $entityManager->find(UserAgency::class,1);

        $client->loginUser($userAgency);

        // Go to the page rental receipts to create a rentalreceipts
        $rental = $entityManager->find(Rental::class,1);
        $crawler = $client->request(Request::METHOD_GET, $urlGenerator->generate('app_rental_receipts', ['id' => $rental->getId()]));

        // Verify that the form is displayed
        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertSelectorExists('form[name="rental_receipts"]');
        // Manage the form
        $form = $crawler->filter('form[name=rental_receipts]')->form([
            'rental_receipts[startAt]' => "2022-10-01",
            'rental_receipts[endAt]' => "2022-10-30",
        ]);

        $client->submit($form);

        // Manage the redirection
        $this->assertResponseStatusCodeSame(302);

        $client->followRedirect();

        //Manage the routing
        $this->assertRouteSame('app_rental_show');
    }
}