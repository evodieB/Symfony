<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class JoueurRepositoryTest extends WebTestCase {

    private $joueurRepository;

    public function testRechercherJoueurSuivantADroite() {

        $j = $this->joueurRepository->rechercherJoueurSuivantADroite(1, 0);
        $this->assertEquals(1, $j->getOrdre());
    }

    protected function setUp() {
        $this->joueurRepository = self::bootKernel()->getContainer()->get("App\Repository\JoueurRepository");
    }

//    public function testSomething()
//    {
//        $client = static::createClient();
//        $crawler = $client->request('GET', '/');
//
//        $this->assertSame(200, $client->getResponse()->getStatusCode());
//        $this->assertContains('Hello World', $crawler->filter('h1')->text());
//    }
}
