<?php

namespace App\Tests\Controller;

use App\Repository\UserAgencyRepository;
use App\Tests\Entity\UserAgencyTest;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

Class UserAgencyControllerTest extends WebTestCase
{
    public function testVisitingWhileLoggedIn()
    {
        $client = static::createClient();
        $userAgencyRepository = static::getContainer()->get(UserAgencyRepository::class);

        // retrieve the test user
        $testUserAgency = $userAgencyRepository->findOneByEmail(UserAgencyTest::USER_AGENCY_EMAIL);

        // simulate $testUser being logged in
        $client->loginUser($testUserAgency);

        // test e.g. the profile page
        $client->request('GET', '/');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Bienvenue !');
    }
}



