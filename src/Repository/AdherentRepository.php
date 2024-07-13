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
            // ->from(Adherent::class,'a')
            // ->from(Licence::class,'l')
            // ->addSelect( array('l'))
            // ->select(array('a','l','g'))
            // ->addSelect(('l.numero'))
            ->leftJoin('a.licence', 'l')
            ->leftJoin('l.grade', 'g')
            ->getQuery();

        return $query = $qb->execute();
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
