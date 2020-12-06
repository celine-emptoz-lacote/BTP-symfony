<?php

namespace App\Repository;

use App\Entity\Heures;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Heures|null find($id, $lockMode = null, $lockVersion = null)
 * @method Heures|null findOneBy(array $criteria, array $orderBy = null)
 * @method Heures[]    findAll()
 * @method Heures[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HeuresRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Heures::class);
    }

    public function recupHeures($semaine,$id){
        $entityManager = $this->getEntityManager();
        
        
        $query = $entityManager->createQuery(
            "SELECT p , sum(p.compteur) AS heure
             FROM App\Entity\Heures p
             WHERE p.semaine = $semaine AND p.id_user = $id ");
     
        // returns an array of Product objects
        return $query->execute();
    }


    // /**
    //  * @return Heures[] Returns an array of Heures objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Heures
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
