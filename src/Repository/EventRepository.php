<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Event>
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);




    }



    public function calendarEvent($from,$to){

        $qb= $this->createQueryBuilder('e');

        $qb->select(array('DISTINCT e.titre, e.beginAt, e.endAt'))
            ->where( $qb->expr()->between('e.beginAt', ':from', ':to'))
            ->orWhere( $qb->expr()->between('e.endAt', ':from', ':to'))
            ->setParameter('from',$from)
            ->setParameter('to',$to);

        $query = $qb->orderBy('e.beginAt', 'ASC')
            ->getQuery()
            ->execute();
            ;
        return $query;
    }

//    /**
//     * @return Event[] Returns an array of Event objects
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

//    public function findOneBySomeField($value): ?Event
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
