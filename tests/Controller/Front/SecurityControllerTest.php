<?php

namespace App\Tests\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    public function testLogin(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $this->assertResponseIsSuccessful();

        $crawler = $client->submitForm("Connexion", [
            "_username" => "manager@oclock.io",
            "_password" => "manager"
        ]);

        $crawler = $client->followRedirect();
        $this->assertSelectorTextContains("h1", "Films, séries TV et popcorn en illimité.");
    }
}
