<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PartieServiceTest extends WebTestCase
{
  /**
     *
     * @var App\Repository\PartieService
     */
    private $partieService;
    
    //public function testCreatePartieOK(){
        //$partie = $this->partieService->createPartie("partie ??? ");
      //  $this->assertNotNull($partie);
    //} 
    
    //public function testjoinPartieOK(){
       //$bool = $this->partieService->joinPartie(1,2);
        //$this->assertNotEquals(0,$bool);
    //}
    
//    public function testDemarrerPartieOK(){
//        $string = $this->partieService->demarrerPartie(1);
//        $this->assertEquals('ok', $string);
//    }
//   
//     protected function setUp() {
//        $this->partieService = self::bootKernel()->getContainer()->get("App\Service\PartieService");
//    }
   
    
     public function testPasserTour(){
        $string = $this->partieService->passerTour(1);
        //$this->assertEquals('ok', $string);
    }
   
     protected function setUp() {
        $this->partieService = self::bootKernel()->getContainer()->get("App\Service\PartieService");
        
    }
//     public function testJoueurSuivant(){
//        $string = $this->partieService->demarrerPartie(1);
//        $this->assertEquals('ok', $string);
//    }
//   
//     protected function setUp() {
//        $this->partieService = self::bootKernel()->getContainer()->get("App\Service\PartieService");
//    }
}
