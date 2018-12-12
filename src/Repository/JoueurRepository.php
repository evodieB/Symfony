<?php

namespace App\Repository;

use App\Entity\Joueur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Joueur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Joueur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Joueur[]    findAll()
 * @method Joueur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JoueurRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Joueur::class);
    }
    public function rechercherJoueurSuivantADroite($idPartie, $ordre){
        
        $query = $this->getEntityManager()->createQuery(""
               . "SELECT j "
               . "FROM App:Joueur j "
               . "     JOIN j.partie p "
               . "WHERE j.etat<>:ETAT "
               . "       AND p.id=:ID_PARTIE "
               . "       AND j.ordre>:ORDRE "
               . "ORDER BY j.ordre ");

       $query->setParameter("ETAT", Joueur::ETAT_ELIMINE);
       $query->setParameter("ID_PARTIE", $idPartie);
       $query->setParameter("ORDRE", $ordre);
        
        $joueurTriesParOrdre = $query->getResult();
        
        if( count($joueurTriesParOrdre)== 0){
            return null;
        }else{
                return $joueurTriesParOrdre[0];
            }
        }
    
    public function rechercherJoueurParPartieIdEtOrdre($partieId, $ordre){
        
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select("j");
        $qb->from("App:Joueur", "j");
        $qb->join("j.partie","p");
        $qb->where("p.id=:ID_PARTIE");
        $qb->andWhere("j.ordre=:ORDRE");
        $qb->setParameter("ORDRE", $ordre);
        $qb->setParameter("ID_PARTIE", $partieId);
        
        $query = $qb->getQuery();
        return $query->getSingleResult();
    }     
}
