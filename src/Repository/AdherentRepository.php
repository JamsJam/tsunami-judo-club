<?php

namespace App\Repository;

use App\Entity\Adherent;
use App\Entity\Licence;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManager;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<Adherent>
 */
class AdherentRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Adherent::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof Adherent) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    public function findAllByJoinedToLicence()
    {
        // $entityManager = $this->getEntityManager();

        // $query = $entityManager->createQuery(
        //     'SELECT a l, g
        //     FROM App\Entity\Adherent a
        //     INNER JOIN a.licence l
        //     INNER JOIN l.grade g'
        // );


        // return $query->getResult();
        
        //todo creeate query builder for index 
        $qb = $this->createQueryBuilder('a')
            ->addSelect(array('a'))
            ->addSelect(array('l'))
            ->addSelect(array('g'))
            ->addSelect(array('gr'))
            ->addSelect(array('t'))
            
            ->innerJoin('a.licence', 'l')
            ->innerJoin('l.grade', 'g')
            ->innerJoin('l.groupes', 'gr')
            ->innerJoin('l.type', 't')
            ->getQuery();

        return $query = $qb->execute();
    }


    /**
     * @param string $q la valeur de recherche
     * @param array $f ensemble des filtes
     * @param int $c numero de la page actuel
     * @param int $p item par page
     * 
     */
    public function searchIndex(string $q , mixed $f, ?int $c = null, ?int $p = null)
    {

        $qb = $this->createQueryBuilder('a')
            ->Select(array('DISTINCT a.uuid','a.nom','a.prenom','a.birthAt',))
            ->addSelect('l.numero')
            ->addSelect(array('g.ceinture','g.grade'))

            ->leftJoin('a.licence', 'l')
            ->leftJoin('l.grade', 'g')
            ->leftJoin('l.groupes', 'gr')
            // ->leftJoin('l.type', 't')
            // ->leftJoin('l.arbitrelvl', 'ar')
            // ->leftJoin('l.commissairelvl', 'c');
            ;
        //! ====== Search query
            if ((strlen($q) > 0 )  ) {

                $qb->andwhere( $qb->expr()->like('a.nom',':query') )
                    ->orWhere( $qb->expr()->like('a.prenom',':query'))
                    ->orWhere( $qb->expr()->like('l.numero',':query') )
                    ->setParameter('query' , '%' . $q . '%');
                    
            };
            
            
        //! ====== Filter query
            if( strlen($f['grade']) > 0){
                $qb->andWhere( $qb->expr()->like('g.ceinture',':gradefilter') )
                    ->setParameter('gradefilter' ,  $f['grade'] );
            };
            if( strlen($f['arbitre']) > 0){
                $qb->andWhere( $qb->expr()->like('ar.niveaux',':arbitrefilter') )
                    ->setParameter('arbitrefilter' ,  $f['arbitre'] );
            };
            if(strlen($f['commissaire']) > 0){
                $qb->andWhere( $qb->expr()->like('c.niveaux',':commissairefilter') )
                    ->setParameter('commissairefilter' ,  $f['commissaire'] );
            };
            if(count($f['yearRange']) > 0){
                $qb->andWhere( $qb->expr()->between('a.birthAt', ':rangeMin', ':rangeMax') )
                    ->setParameter('rangeMin' , end($f['yearRange'])  . '-01-01') 
                    ->setParameter('rangeMax' , $f['yearRange'][0]  . '-12-31' );
            };
            if($f['groupe'] && count($f['groupe'])){
                $groupCount = count($f['groupe']);
                $qb->andWhere($qb->expr()->in('gr.nom', ':groupes'))
                    ->setParameter('groupes', $f['groupe'])
                    ->groupBy('a.id', 'a.nom', 'a.prenom', 'a.birthAt', 'l.numero', 'g.ceinture', 'g.grade')
                    ->having('COUNT(DISTINCT gr.nom) = :groupCount')
                    ->setParameter('groupCount', $groupCount);
            };
        
        $query = $qb->orderBy('a.nom', 'ASC')
            
            ->getQuery()
            ->execute();

        return $query;
    }


    //    /**
    //     * @return Adherent[] Returns an array of Adherent objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Adherent
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
