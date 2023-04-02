<?php

namespace App\Tests\Functional;

use App\Entity\Tenant;
use App\Entity\UserAgency;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class TenantFunctionalTest extends WebTestCase
{
    public function testIfCreateATenantIsSuccessfull(): void
    {
        $client = static::createClient();
        //Get the urlgenerator
        $urlGenerator = $client->getContainer()->get('router');

        //Get the entity manager
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');
        
        $userAgency = $entityManager->find(UserAgency::class,1);

        $client->loginUser($userAgency);

        // Go to the page apartment new to create a apartment
        $crawler = $client->request(Request::METHOD_GET, $urlGenerator->generate('app_tenant_new'));

        // Manage the form
        $form = $crawler->filter('form[name=tenant]')->form([
            'tenant[lastName]' => "Monde",
            'tenant[firstName]' => "James",
            'tenant[dateOfBirth]' => "1996-10-08",
            'tenant[birthPlace]' => "Marseille",
            'tenant[civilStatus]' => "marié(e)",
            'tenant[email]' => "jamesmonde@studi.fr",
            'tenant[phone]' => "0601020304",
            'tenant[address]' => "20 Chemin des Guarrigues",
            'tenant[city]' => "Marseille",
            'tenant[zipCode]' => "13000",
            'tenant[guarantor]' => "Jean Monde",
        ]);

        $client->submit($form);

        // Manage the redirection
        $this->assertResponseStatusCodeSame(303);

        $client->followRedirect();

        //Manage the routing
        $this->assertRouteSame('app_tenant_index');
    }
    public function testIfReadATenantIsSuccessfull(): void
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
            $urlGenerator->generate('app_tenant_new'));

        $this->assertResponseIsSuccessful();
        $this->assertRouteSame('app_tenant_new');
    }

    public function testIfUpdateARentalIsSuccessfull(): void
{
    $client = static::createClient();

    //Get the urlgenerator
    $urlGenerator = $client->getContainer()->get('router');

    //Get the entity manager
    $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');

    $userAgency = $entityManager->find(UserAgency::class,1);
    $tenant = $entityManager->getRepository(Tenant::class)->findAll()[0];
    $client->loginUser($userAgency);

    $crawler = $client->request(
        Request::METHOD_GET, 
        $urlGenerator->generate('app_tenant_edit', ['id' => $tenant->getId()])
    );

    $this->assertResponseIsSuccessful();

    // Get the form from the crawler
    $form = $crawler->filter('form[name=tenant]')->form([
        'tenant[lastName]' => "Monde",
        'tenant[firstName]' => "James",
        'tenant[dateOfBirth]' => "1996-10-08",
        'tenant[birthPlace]' => "Marseille",
        'tenant[civilStatus]' => "célibataire",
        'tenant[email]' => "jamesmonde@studi.fr",
        'tenant[phone]' => "0601020304",
        'tenant[address]' => "20 Chemin des Guarrigues",
        'tenant[city]' => "Marseille",
        'tenant[zipCode]' => "13000",
        'tenant[guarantor]' => "Jean Monde",
    ]);

    $client->submit($form);

    // Manage the redirection
    $this->assertResponseStatusCodeSame(303);

    $client->followRedirect();

    //Manage the routing
    $this->assertRouteSame('app_tenant_index');
}

    public function testIfDeleteATenantIsSuccessfull(): void
    {
        $client = static::createClient();

        //Get the urlgenerator
        $urlGenerator = $client->getContainer()->get('router');

        //Get the entity manager
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');
        
        $userAgency= $entityManager->find(UserAgency::class,1);
        $tenant = $entityManager->getRepository(Tenant::class)->findAll()[0];

        $client->loginUser($userAgency);

        $client->request(
            Request::METHOD_POST, 
            $urlGenerator->generate('app_tenant_delete', ['id' => $tenant->getId()])
        );
            $this->assertResponseStatusCodeSame(303);

        $client->followRedirect();

        //Manage the routing
        $this->assertRouteSame('app_tenant_index');
    }
}


