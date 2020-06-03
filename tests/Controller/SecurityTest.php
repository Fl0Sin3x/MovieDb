<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityTest extends WebTestCase
{
    /**
     * @dataProvider getRoutes
     */
    public function testAsAdmin($routeName)
    {
        // On fera les requêtes en tant que marion@oclock.io
        $client = static::createClient([], [
            'PHP_AUTH_USER' => 'marion@oclock.io',
            'PHP_AUTH_PW'   => 'root',
        ]);
        $crawler = $client->request('GET', $routeName);

        // Pour cette route, on doit obtenir une 200
        $this->assertResponseIsSuccessful();
    }

    /**
     * @dataProvider getRoutes
     */
    public function testAsAnonymous($routeName)
    {
        // On ne précise pas de connexion,
        // on fera les requête en tant qu'utilisateur anonyme
        $client = static::createClient();
        $crawler = $client->request('GET', $routeName);

        $this->assertResponseRedirects();
    }

    public function getRoutes()
    {
        return [
            ['/movie/list'],
            ['/category/list'],
            ['/post/'],
            ['/admin/?action=list&entity=Movie'],
            ['/movie/1/view']
        ];
    }
}
