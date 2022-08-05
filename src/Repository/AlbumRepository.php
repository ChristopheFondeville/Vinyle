<?php

namespace App\Repository;

use App\Entity\Album;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use DoctrineExtensions\Query\Mysql\Rand;

/**
 * @extends ServiceEntityRepository<Album>
 *
 * @method Album|null find($id, $lockMode = null, $lockVersion = null)
 * @method Album|null findOneBy(array $criteria, array $orderBy = null)
 * @method Album[]    findAll()
 * @method Album[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AlbumRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Album::class);
    }

    public function add(Album $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Album $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function lastFiveRegistered($user): array
    {
        return $this->createQueryBuilder('a')
            ->select('a')
            ->join('a.users', 'u')
            ->andWhere('u.id = :user_id')
            ->setParameter('user_id', $user)
            ->orderBy('a.date_added', 'ASC')
            ->setMaxResults(5)
            ->getQuery()
            ->execute();
    }

    public function albumByArtist($artist): array
    {
        return $this->createQueryBuilder('a')
            ->select('a')
            ->andWhere('a.artist = :artist')
            ->setParameter('artist', $artist)
            ->orderBy('a.titre')
            ->getQuery()
            ->execute();
    }

    public function randAlbum($user): array
    {
        return $this->createQueryBuilder('a')
            ->join('a.users', 'u')
            ->andWhere('u.id = :user_id')
            ->setParameter('user_id', $user)
            ->orderBy('Rand()')
            ->setMaxResults(5)
            ->getQuery()
            ->execute();
    }

    public function searchAlbum($letter, $user): array
    {
        return $this->createQueryBuilder('a')
            ->join('a.users', 'u')
            ->andWhere('u.id = :user_id')
            ->andWhere('a.titre like :letter')
            ->setParameters([
                'user_id' => $user,
                'letter' => "$letter%",
            ])
            /*->setParameter('letter', "$letter%")*/
            ->orderBy('a.titre')
            ->getQuery()
            ->getResult();
    }

    public function totalVinylsUser($user): array
    {
        return $this->createQueryBuilder('a')
            ->select('a')
            ->join('a.users','u')
            ->andWhere('u.id = :user_id')
            ->setParameter('user_id', $user)
            ->getQuery()
            ->execute();
    }

//    /**
//     * @return Album[] Returns an array of Album objects
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

//    public function findOneBySomeField($value): ?Album
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
