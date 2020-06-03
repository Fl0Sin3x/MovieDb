<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

// On se sert de ce test pour vérfier les fonctionnalités d'ajout,
// modification ou suppression

class MovieControllerTest extends WebTestCase
{
    public function testAdd()
    {
        // On crée le client en se connectant avec un ROLE_ADMIN
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'marion@oclock.io',
            'PHP_AUTH_PW'   => 'root',
        ]);
        // On tente de joindre /movie/add en GET
        $crawler = $client->request('POST', '/movie/add', [
            'body' => [
                'movie' => [
                    'title' => 'Kaamelott',
                    'releaseDate' => '2020-11-12',
                    'categories' => [1,3,5],
                    'director' => 3,
                    'writers' => [2,5,8],
                ]
            ]
        ]);
        // On vérifie que ça fonctionne
        $this->assertResponseRedirects();

        // Ceci ne fonctionne pas pour le moment, on manque un peu de temps
        // L'bjectif était de tester le formulaire d'ajout d'un film.
        // Normalement, quand le formulaire est rempli et envoyé, on est redirigé vers /movie/list
        // On teste donc si on a bien une redirection
        // Le vrai code teste le token CSRF, on devrait donc aussi, ici, créé un token et l'envoyer en POST
        // ou alors trouver une option qui permet de désactiver le token

    }
}
