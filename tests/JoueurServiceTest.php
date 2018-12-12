<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class JoueurServiceTest extends WebTestCase
{
    
    /**
     *
     * @var App\Service\JoueurService
     */
    private $joueurService;
    
    public function testInscriptionOuReinitialisationOK(){
        $joueur = $this->joueurService->inscriptionOuReinitialisation("A new Character 3", "Avatar_3");
        $this->assertNotNull($joueur);
    } 
    
    
        
    protected function setUp() {
        $this->joueurService = self::bootKernel()->getContainer()->get("App\Service\JoueurService");
    }
    
    
   
}
