<?php

namespace App\Repository;

use App\Entity\Partie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Partie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Partie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Partie[]    findAll()
 * @method Partie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PartieRepository extends ServiceEntityRepository
{
     
    public function listePartie(){
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();
        $qb->select('p');
        $qb->from('App:Partie', 'p');
        $qb->join('p.joueurs', 'j');
        $qb->andWhere('p.etat = :Etat') ;
        $qb->having('COUNT(j) <= 4');
        $qb->setParameter('Etat', Partie::ETAT_PARTIE_NON_DEMARREE);
        $query = $qb->getQuery();
        //$res = $query->getScalarResult();
        $res = $query->getResult();
        return $res;
    }
    
     public function ordreMax($partieId){
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select("MAX(j.ordre) +1");
        $qb->from("App:Joueur", "j");
        $qb->join("j.partie", "p");
        $qb->andWhere("p.id = ".$partieId);
        
        $query = $qb->getQuery();
        $l = $query->getSingleScalarResult();
        
        if($l == null){
            return 1;
        }
        return $l;
    }
    
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Partie::class);
    }
    
    


    // /**
    //  * @return Partie[] Returns an array of Partie objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Partie
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}