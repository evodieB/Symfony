<?php

namespace App\Service;

use App\Entity\Partie;
use App\Entity\Joueur;
use Doctrine\ORM\EntityManagerInterface;


/**
 * Description of PartieService
 *
 * @author Administrateur
 */
class PartieService {
    
    
    /**
     *
     * @var EntityManagerInterface
     */
    private $em;
    
    /**
     * @var \App\Repository\PartieRepository
     */
    private $pr;
    
    /**
     * @var \App\Repository\JoueurRepository
     */
    private $jr;
    
    /**
     * @var \App\Service\CarteService
     */
    private $cs;
     /**
     * @var \App\Repository\CarteRepository
     */
    private $cr;
    
    function __construct(EntityManagerInterface $em, \App\Repository\PartieRepository $pr, \App\Repository\JoueurRepository $jr, \App\Service\CarteService $cs,\App\Repository\CarteRepository $cr) {
        $this->em = $em;
        $this->pr = $pr;
        $this->jr = $jr;
        $this->cs = $cs;
        $this->cr = $cr;
    }
    
    public function createPartie($nom){
        $partie = new Partie();
        $partie->setNom($nom);
        $partie->setEtat(Partie::ETAT_PARTIE_NON_DEMARREE);
        $this->em->persist($partie);
        $this->em->flush();
        
        return $partie;
    }
    
    public function joinPartie($partieID, $joueurID){
        $partie = $this->pr->find($partieID);
        
        if(count($partie->getJoueurs()) >= 5 ){
            throw new Exception("La partie contient deja 5 joueurs");     
        }
        
        $joueur = $this->jr->find($joueurID);
        $partie->addJoueur($joueur);
        $ordre = $this->pr->ordreMax($partieID);
        $joueur->setOrdre($ordre);
        
        $this->em->flush();
        return $partie->getJoueurs();   
    } 
    
    public function demarrerPartie($idPartie){
        $partie = $this->pr->find($idPartie);
        $partie->setOrdreActuel(1);
        foreach($partie->getJoueurs() as $joueurAct ){
            for($i = 0; $i < 7; $i++){
                $carte = $this->cs->piocherCarte();
                $joueurAct->addCarte($carte);
                $carte->setJoueur($joueurAct);
                $this->em->persist($carte);
            }
            $joueurAct->setEtat(Joueur::ETAT_PAS_ELIMINE);
        }
        // definir etat des joueurs
        $partie->setEtat(Partie::ETAT_PARTIE_DEMARREE);
        $this->em->flush();
        return 'ok';
    }
    
    public function passerJoueurSuivant($idPartie){
        $partie = $this->pr->find($idPartie);
        $ordre = $partie->getOrdreActuel();
        //Recup joueur suivant à droite  
        $joueurAct = $this->jr->rechercherJoueurSuivantADroite($idPartie, $ordre);
        $partie->setOrdreActuel($joueurAct->getOrdre());
            
        return '';
         
    }
    
    public function passerTour($joueurID){
        // joueur recupere une carte
        $joueur = $this->jr->find($joueurID);
        $carte  = $this->cs->piocherCarte();
        $joueur->addCarte($carte);
        $carte->setJoueur($joueur);
        
        
        $this->em->persist($carte);
        
        // passe au joueur suivant
        $partie = $joueur->getPartie();
        $idPartie = $partie->getId();
        $this->passerJoueurSuivant($idPartie);
        $this->em->flush();
    }
    
    public function lancerSort($joueurID, $carte1, $carte2, $target = null){
        $carte1 = $this->cr->find($carte1); 
        $carte2 = $this->cr->find($carte2); 
        
        
        //détermine le sort à lançer(test condition entre type de cartes (if))
        $sort = [$carte1, $carte2];
        
                 //invisibilité

        // retire les 2 cartes du joueur
        // $res = effet du sort 
        // si res != null ajouter res au joueur
        // si un joueur a 0 cartes il a perdu
        // si il rest que un seul joueur il a gagner
        // passe au joueur suivant
    }
}
