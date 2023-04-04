<?php

namespace App\Tests\Functional;

use App\Entity\UserAgency;
use App\Entity\Payment;
use App\Entity\Rental;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class PaymentFunctionalTest extends WebTestCase
{
    public function testIfCreateAPaymentIsSuccessfull(): void
    {
        $client = static::createClient();
        //Get the urlgenerator
        $urlGenerator = $client->getContainer()->get('router');

        //Get the entity manager
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');
        
        $userAgency = $entityManager->find(UserAgency::class,1);

        $client->loginUser($userAgency);

        // Go to the page Payment new to create a payment
        $rental = $entityManager->find(Rental::class,1);
        $crawler = $client->request(Request::METHOD_GET, $urlGenerator->generate('app_payment_new', ['id' => $rental->getId()]));

        // Manage the form
        $form = $crawler->filter('form[name=payment]')->form([
            'payment[paymentAt]' => "2022-10-08",
            'payment[amount]' => 550.1,
            'payment[type]' => "APL",
            'payment[paymentMethod]' => "Virement",
        ]);

        $client->submit($form);

        // Manage the redirection
        $this->assertResponseStatusCodeSame(303);

        $client->followRedirect();

        //Manage the routing
        $this->assertRouteSame('app_payment_index');
    }
    public function testIfReadAPaymentIsSuccessfull(): void
    {
        $client = static::createClient();
        //Get the urlgenerator
        $urlGenerator = $client->getContainer()->get('router');

        //Get the entity manager
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');
        
        $userAgency = $entityManager->find(UserAgency::class,1);

        $client->loginUser($userAgency);

        // Go to the page Payment new to create a payment
        $rental = $entityManager->find(Rental::class,1);
        $client->request(
            Request::METHOD_GET, 
            $urlGenerator->generate('app_payment_new',['id' => $rental->getId()]));

        $this->assertResponseIsSuccessful();
        $this->assertRouteSame('app_payment_new');
    }

    public function testIfUpdateAPaymentIsSuccessfull(): void
{
    $client = static::createClient();

    //Get the urlgenerator
    $urlGenerator = $client->getContainer()->get('router');

    //Get the entity manager
    $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');

    $userAgency = $entityManager->find(UserAgency::class,1);
    $payment = $entityManager->getRepository(Payment::class)->findAll()[0];

    $client->loginUser($userAgency);

    $crawler = $client->request(
        Request::METHOD_GET, 
        $urlGenerator->generate('app_payment_edit', ['id' => $payment->getId()])
    );

    $this->assertResponseIsSuccessful();

    // Get the form from the crawler
    $form = $crawler->filter('form[name=payment]')->form([
        'payment[paymentAt]' => "2022-10-08",
        'payment[amount]' => 560.1,
        'payment[type]' => "APL",
        'payment[paymentMethod]' => "Virement",
    ]);

    $client->submit($form);

    // Manage the redirection
    $this->assertResponseStatusCodeSame(303);

    $client->followRedirect();

    //Manage the routing
    $this->assertRouteSame('app_payment_index');
}

    public function testIfDeleteAPaymentIsSuccessfull(): void
    {
        $client = static::createClient();

        //Get the urlgenerator
        $urlGenerator = $client->getContainer()->get('router');

        //Get the entity manager
        $entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');
        
        $userAgency= $entityManager->find(UserAgency::class,1);
        $payment = $entityManager->getRepository(Payment::class)->findAll()[0];

        $client->loginUser($userAgency);

        $client->request(
            Request::METHOD_POST, 
            $urlGenerator->generate('app_payment_delete', ['id' => $payment->getId()])
        );
        $this->assertResponseStatusCodeSame(303);

        $client->followRedirect();

        //Manage the routing
        $this->assertRouteSame('app_payment_index');
    }
}
