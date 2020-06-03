<?php

namespace App\Tests\Service;

use App\Service\Slugger;
use PHPUnit\Framework\TestCase;

class SluggerTest extends TestCase
{
    public function testSlugify()
    {
        // On souhaite tester la méthode slugify() du Slugger
        // On doit d'abord instancier le Slugger
        $slugger = new Slugger();

        // On écrit nos tests
        // On vérifie certaines valerus fixe qui nous servent d'exemple
        // pour confirmer que slugify correspond à nos critères
        $this->assertEquals('seven', $slugger->slugify('Seven'));
        $this->assertEquals('rrrrrrr-', $slugger->slugify('RRRrrrr !!!'));
        $this->assertEquals('2012', $slugger->slugify('2012'));
        $this->assertEquals('star-wars-episode-iii-la-revanche-des-sith',
            $slugger->slugify('Star Wars: Episode III - La revanche des Sith'));

    }
}
