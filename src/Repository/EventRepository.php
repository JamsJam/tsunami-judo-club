<?php

namespace App\Repository;

use App\Entity\Event;
use DateTimeImmutable;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Event>
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);




    }



    /**
     * Return an array event between from date and to date
     *
     * @param DateTimeImmutable $from
     * @param DateTimeImmutable $to
     * @return Event[] 
     */
    public function calendarEvent(DateTimeImmutable $from, DateTimeImmutable $to){

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



    /**
     * Undocumented function
     *
     * @param DateTimeImmutable $date
     * @return Event[] Returns an array of Event objects
     */
    public function getEventOfTheDay(DateTimeImmutable $date){

        $qb= $this->createQueryBuilder('e');

        $qb->select(array('DISTINCT e.titre, e.beginAt, e.endAt, e.isPublic, te.nom'))
            ->leftJoin('e.type', 'te')
            ->where(
                $qb->expr()->orX(
                    $qb->expr()->eq('e.beginAt', ':date'),
                    $qb->expr()->eq('e.endAt', ':date'),
                    $qb->expr()->between(':date', 'e.beginAt', 'e.endAt')
                ))
            ->setParameter('date',$date->setTime(0, 0, 0));


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
