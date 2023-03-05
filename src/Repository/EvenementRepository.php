<?php

namespace App\Repository;

use App\Entity\Evenement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Evenement>
 *
 * @method Evenement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Evenement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Evenement[]    findAll()
 * @method Evenement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EvenementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Evenement::class);
    }

    public function save(Evenement $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Evenement $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Evenement[] Returns an array of Evenement objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Evenement
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

function sortByDate()
{
    return $this->createQueryBuilder('s')
        //->Where('s.creation_date <= CURRENT_DATE()')
        ->orderBy('s.DateDebutE', 'DESC')
        ->setMaxResults(3)
        ->getQuery()
        ->getResult()
    ; 
}

public function sortByName(): array
{
    return $this->createQueryBuilder('s')
        ->orderBy('s.NomEvent', 'ASC')
        ->getQuery()
        ->getResult()
    ;
}

public function sortPrix(): array
{
    return $this->createQueryBuilder('s')
        ->orderBy('s.PrixTicket', 'ASC')
        ->getQuery()
        ->getResult()
    ;
}


public function sortByNbrP(): array
{
    return $this->createQueryBuilder('s')
        ->orderBy('s.nbrPlaces', 'DESC')
        ->getQuery()
        ->getResult()
    ;
}


}
