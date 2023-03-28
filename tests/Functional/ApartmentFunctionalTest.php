<?php

namespace App\Tests\Functional;

use App\Entity\Apartment;
use App\Entity\UserAgency;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class ApartmentFunctionalTest extends WebTestCase
{
    public function testIfCreateAnApartmentIsSuccessfull(): void
    {
        $client = static::createClient();
        //Get the urlgenerator
        $urlGenerator = $client->getContainer()->get('router');

        //Get the entity manager
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');
        
        $userAgency = $entityManager->find(UserAgency::class,1);

        $client->loginUser($userAgency);

        // Go to the page apartment new to create a apartment
        $crawler = $client->request(Request::METHOD_GET, $urlGenerator->generate('app_apartment_new'));

        // Manage the form
        $form = $crawler->filter('form[name=apartment]')->form([
            'apartment[address]' => "10 rue de la Rose",
            'apartment[additionalAddressDetails]' => "Appartment 2B",
            'apartment[city]' => "Marseille",
            'apartment[zipCode]' => "13000",
        ]);

        $client->submit($form);

        // Manage the redirection
        $this->assertResponseStatusCodeSame(303);

        $client->followRedirect();

        //Manage the routing
        $this->assertRouteSame('app_apartment_index');
    }
    public function testIfReadAnApartmentIsSuccessfull(): void
    {
        $client = static::createClient();
        //Get the urlgenerator
        $urlGenerator = $client->getContainer()->get('router');

        //Get the entity manager
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');
        
        $userAgency = $entityManager->find(UserAgency::class,1);

        $client->loginUser($userAgency);

        // Go to the page apartment new to create a apartment
        $client->request(
            Request::METHOD_GET, 
            $urlGenerator->generate('app_apartment_new'));

        $this->assertResponseIsSuccessful();
        $this->assertRouteSame('app_apartment_new');
    }

    public function testIfUpdateARentalIsSuccessfull(): void
{
    $client = static::createClient();

    //Get the urlgenerator
    $urlGenerator = $client->getContainer()->get('router');

    //Get the entity manager
    $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');

    $userAgency = $entityManager->find(UserAgency::class,1);
    $apartment = $entityManager->getRepository(Apartment::class)->findAll()[0];

    $client->loginUser($userAgency);

    $crawler = $client->request(
        Request::METHOD_GET, 
        $urlGenerator->generate('app_apartment_edit', ['id' => $apartment->getId()])
    );

    $this->assertResponseIsSuccessful();

    // Get the form from the crawler
    $form = $crawler->filter('form[name=apartment]')->form([
        'apartment[address]' => "10 rue de la République",
        'apartment[additionalAddressDetails]' => "Appartment 2Bis",
        'apartment[city]' => "Marseille",
        'apartment[zipCode]' => "13000",
    ]);

    $client->submit($form);

    // Manage the redirection
    $this->assertResponseStatusCodeSame(303);

    $client->followRedirect();

    //Manage the routing
    $this->assertRouteSame('app_apartment_index');
}

    public function testIfDeleteAnApartmentIsSuccessfull(): void
    {
        $client = static::createClient();

        //Get the urlgenerator
        $urlGenerator = $client->getContainer()->get('router');

        //Get the entity manager
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');
        
        $userAgency= $entityManager->find(UserAgency::class,1);
        $apartment = $entityManager->getRepository(Apartment::class)->findAll()[0];

        $client->loginUser($userAgency);

        $client->request(
            Request::METHOD_POST, 
            $urlGenerator->generate('app_apartment_delete', ['id' => $apartment->getId()])
        );
            $this->assertResponseStatusCodeSame(303);

        $client->followRedirect();

        //Manage the routing
        $this->assertRouteSame('app_apartment_index');
    }
}


