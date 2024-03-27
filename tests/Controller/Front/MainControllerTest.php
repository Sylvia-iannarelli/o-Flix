<?php

namespace App\Tests\Controller\Front;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MainControllerTest extends WebTestCase
{
    public function testHomeAnonyme(): void
    {
        // Equivaut à créer un "faux" navigateur
        $client = static::createClient();

        // On crée une requête sur la racine du site
        $crawler = $client->request('GET', '/');

        // On vérifie que la requête renvoit une réponse 200
        $this->assertResponseIsSuccessful();

        // On vérifie qu'il y a bien le lien de login dans la page
        $this->assertSelectorExists("a[href='/login']", "Le lien de connexion n'est pas visible");

        // On vérifie qu'un anonyme n'a pas le lien vers le back-office
        $this->assertSelectorNotExists("a[href='/back-office/film/']","Malgrès l'anonymat le lien du back-office s'affiche");
    }

    public function testHomeAdmin(): void
    {
        // Equivaut à créer un "faux" navigateur
        $client = static::createClient();
        
        // On récupère l'userRepository
        $userRepository = static::getContainer()->get(UserRepository::class);
        
        // On récupère un user de test
        $testUser = $userRepository->findOneByEmail('manager@oclock.io');

        // On connecte l'user de test
        $client->loginUser($testUser);

        // On crée une requête sur la racine du site
        $crawler = $client->request('GET', '/');

        // On vérifie que la requête renvoit une réponse 200
        $this->assertResponseIsSuccessful();

        // On vérifie qu'il y a bien le lien vers le back-office dans la page 
        $this->assertSelectorExists("a[href='/back-office/film/']", "Le lien vers le back-office n'est pas visible");
    }
}
