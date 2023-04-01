<?php

namespace App\Tests\Functional;

use App\Entity\UserAgency;
use App\Entity\InventoryOfFixtures;
use App\Entity\Rental;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class InventoryOfFixturesFunctionalTest extends WebTestCase
{
    public function testIfCreateAnInventoryOfFixturesIsSuccessfull(): void
    {
        $client = static::createClient();
        //Get the urlgenerator
        $urlGenerator = $client->getContainer()->get('router');

        //Get the entity manager
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');
        
        $userAgency = $entityManager->find(UserAgency::class,1);

        $client->loginUser($userAgency);

        // Go to the page Inventory of Fixtures new to create a inventory
        $rental = $entityManager->find(Rental::class,1);
        $crawler = $client->request(Request::METHOD_GET, $urlGenerator->generate('app_inventory_of_fixtures_new', ['id' => $rental->getId()]));

        // Manage the form
        $form = $crawler->filter('form[name=inventory_of_fixtures]')->form([
            'inventory_of_fixtures[status]' => 1,
            'inventory_of_fixtures[comments]' => "Très bon état",
        ]);

        $client->submit($form);

        // Manage the redirection
        $this->assertResponseStatusCodeSame(303);

        $client->followRedirect();

        //Manage the routing
        $this->assertRouteSame('app_inventory_of_fixtures_index');
    }
    public function testIfReadAnInventoryOfFixturesIsSuccessfull(): void
    {
        $client = static::createClient();
        //Get the urlgenerator
        $urlGenerator = $client->getContainer()->get('router');

        //Get the entity manager
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');
        
        $userAgency = $entityManager->find(UserAgency::class,1);

        $client->loginUser($userAgency);

        // Go to the page Inventory of Fixtures new to create an inventory
        $rental = $entityManager->find(Rental::class,1);
        $client->request(
            Request::METHOD_GET, 
            $urlGenerator->generate('app_inventory_of_fixtures_new',['id' => $rental->getId()]));

        $this->assertResponseIsSuccessful();
        $this->assertRouteSame('app_inventory_of_fixtures_new');
    }

    public function testIfUpdateAnInventoryOfFixturesIsSuccessfull(): void
{
    $client = static::createClient();

    //Get the urlgenerator
    $urlGenerator = $client->getContainer()->get('router');

    //Get the entity manager
    $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');

    $userAgency = $entityManager->find(UserAgency::class,1);
    $inventoryOfFixtures = $entityManager->getRepository(InventoryOfFixtures::class)->findAll()[0];

    $client->loginUser($userAgency);

    $crawler = $client->request(
        Request::METHOD_GET, 
        $urlGenerator->generate('app_inventory_of_fixtures_edit', ['id' => $inventoryOfFixtures->getId()])
    );

    $this->assertResponseIsSuccessful();

    // Get the form from the crawler
    $form = $crawler->filter('form[name=inventory_of_fixtures]')->form([
        'inventory_of_fixtures[status]' => 0,
        'inventory_of_fixtures[comments]' => "Très bon état",
    ]);

    $client->submit($form);

    // Manage the redirection
    $this->assertResponseStatusCodeSame(303);

    $client->followRedirect();

    //Manage the routing
    $this->assertRouteSame('app_inventory_of_fixtures_index');
}

    public function testIfDeleteAnInventoryOfFixturesIsSuccessfull(): void
    {
        $client = static::createClient();

        //Get the urlgenerator
        $urlGenerator = $client->getContainer()->get('router');

        //Get the entity manager
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');
        
        $userAgency= $entityManager->find(UserAgency::class,1);
        $inventoryOfFixtures = $entityManager->getRepository(InventoryOfFixtures::class)->findAll()[0];

        $client->loginUser($userAgency);

        $client->request(
            Request::METHOD_POST, 
            $urlGenerator->generate('app_inventory_of_fixtures_delete', ['id' => $inventoryOfFixtures->getId()])
        );
        $this->assertResponseStatusCodeSame(303);

        $client->followRedirect();

        //Manage the routing
        $this->assertRouteSame('app_inventory_of_fixtures_index');
    }
}
