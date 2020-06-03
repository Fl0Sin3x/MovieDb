<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testHomepage()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        // On vérifie que la requête plus haut retourne une 200
        $this->assertResponseIsSuccessful();

        // On vérifie qu'un certain element dans le DOM contient le nom du projet
        // Ici .navbar-brand contient un logo et MovieDB
        $this->assertSelectorTextContains('.navbar-brand', 'MovieDB');

        // On vérifie la présence de l'image avec le nom du site
        $this->assertSelectorExists('.navbar-brand img');
    }
}
