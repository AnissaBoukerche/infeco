<?php

namespace App\Tests\Functional;

use App\Entity\Rental;
use App\Entity\UserAgency;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;


class RentalFunctionalTest extends WebTestCase
{
    public function testIfCreateRentalIsSuccessfull(): void
    {
        $client = static::createClient();
        //Get the urlgenerator
        $urlGenerator = $client->getContainer()->get('router');

        //Get the entity manager
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');
        
        $userAgency = $entityManager->find(UserAgency::class,1);

        $client->loginUser($userAgency);

        // Go to the page rental new to create a rental
        $crawler = $client->request(Request::METHOD_GET, $urlGenerator->generate('app_rental_new'));

        // Manage the form
        $form = $crawler->filter('form[name=rental]')->form([
            'rental[entryAt]' => "2022-09-08",
            'rental[exitAt]' => "2023-09-08",
            'rental[charges]' => 150.50,
            'rental[rent]' => 350.50,
            'rental[balance]' => 150.50,
        ]);

        $client->submit($form);

        // Manage the redirection
        $this->assertResponseStatusCodeSame(303);

        $client->followRedirect();

        //Manage the routing
        $this->assertRouteSame('app_rental_index');
    }
    public function testIfReadARentalIsSuccessfull(): void
    {
        $client = static::createClient();
        //Get the urlgenerator
        $urlGenerator = $client->getContainer()->get('router');

        //Get the entity manager
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');
        
        $userAgency = $entityManager->find(UserAgency::class,1);

        $client->loginUser($userAgency);

        // Go to the page rental new to create a rental
        $client->request(
            Request::METHOD_GET, 
            $urlGenerator->generate('app_rental_new'));

        $this->assertResponseIsSuccessful();
        $this->assertRouteSame('app_rental_new');
    }

    public function testIfUpdateARentalIsSuccessfull(): void
{
    $client = static::createClient();

    //Get the urlgenerator
    $urlGenerator = $client->getContainer()->get('router');

    //Get the entity manager
    $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');

    $userAgency = $entityManager->find(UserAgency::class,1);
    $rental = $entityManager->getRepository(Rental::class)->findAll()[0];

    $client->loginUser($userAgency);

    $crawler = $client->request(
        Request::METHOD_GET, 
        $urlGenerator->generate('app_rental_edit', ['id' => $rental->getId()])
    );

    $this->assertResponseIsSuccessful();

    // Get the form from the crawler
    $form = $crawler->filter('form[name=rental]')->form([
        'rental[entryAt]' => "2022-10-08",
        'rental[exitAt]' => "2023-10-08",
        'rental[charges]' => 151.50,
        'rental[rent]' => 351.50,
        'rental[balance]' => 153.50,
    ]);

    $client->submit($form);

    // Manage the redirection
    $this->assertResponseStatusCodeSame(303);

    $client->followRedirect();

    //Manage the routing
    $this->assertRouteSame('app_rental_index');
}

    public function testIfDeleteARentalIsSuccessfull(): void
    {
        $client = static::createClient();

        //Get the urlgenerator
        $urlGenerator = $client->getContainer()->get('router');

        //Get the entity manager
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');
        
        $userAgency= $entityManager->find(UserAgency::class,1);
        $rental = $entityManager->getRepository(Rental::class)->findAll()[0];

        $client->loginUser($userAgency);

        $client->request(
            Request::METHOD_POST, 
            $urlGenerator->generate('app_rental_delete', ['id' => $rental->getId()])
        );
        $this->assertResponseStatusCodeSame(303);

        $client->followRedirect();

        //Manage the routing
        $this->assertRouteSame('app_rental_index');
    }
}
