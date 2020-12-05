<?php

namespace App\Repository;

use App\Entity\Pointages;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Pointages|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pointages|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pointages[]    findAll()
 * @method Pointages[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PointagesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pointages::class);
    }

    public function InnerJoin()
    {
        $entityManager = $this->getEntityManager();

        
        //requete permettant de recuperer les infos des 3 tables grace a un inner join
        $query = $this->createQueryBuilder('c')
            
            ->innerJoin('c.chantiers', 'chantiers')
            ->addSelect('chantiers')
            ->innerJoin('c.utilisateurs', 'utilisateurs')
            ->addSelect('utilisateurs');
            return $query->getQuery()->getResult();
            
            
           
        
       
    }

    public function recupDonnee($id)
    {
        //$entityManager = $this->getEntityManager();

        
            
        $entityManager = $this->getEntityManager();

        
        //requete permettant de recuperer les infos des 3 tables grace a un inner join
        $query = $entityManager->createQuery(
            "SELECT p
             FROM App\Entity\Pointages p
             INNER JOIN App\Entity\Utilisateurs u
             WITH p.utilisateurs=u.id  
             WHERE p.utilisateurs = $id ");
     
        // returns an array of Product objects
        return $query->execute();

           
            
            
           
        
       
    }

    public function recupJourTravailler($id,$jour)
    {
        

        
            
        $entityManager = $this->getEntityManager();

        
        
            return $this->createQueryBuilder('p')
                ->innerJoin('p.chantiers', 'chantiers')
                ->addSelect('chantiers')
                ->innerJoin('p.utilisateurs', 'utilisateurs')
                ->addSelect('utilisateurs')
                
                ->getQuery()
                ->getResult()
            ;
        

           
            
            
           
        
       
    }

    // /**
    //  * @return Pointages[] Returns an array of Pointages objects
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
    public function findOneBySomeField($value): ?Pointages
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
