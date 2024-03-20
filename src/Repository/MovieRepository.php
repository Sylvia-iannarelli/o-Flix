<?php

namespace App\Repository;

use App\Entity\Movie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Movie>
 *
 * @method Movie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Movie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Movie[]    findAll()
 * @method Movie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MovieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Movie::class);
    }

    public function add(Movie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Movie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
    * @return Movie[] Returns an array of Movie objects
    */
    public function findAllSearchByTitle($search = null): array
    {
        return $this->createQueryBuilder('m')
            ->orderBy('m.title', 'ASC')
            ->where("m.title LIKE :search")
            ->setParameter("search", "%".$search."%")
            ->getQuery()
            ->getResult()
            ;
    }

    /**
    * @return Movie[] Returns an array of Movie objects
    */
    public function find10OrderByDate(): array
    {
        return $this->createQueryBuilder('m')
            ->orderBy('m.releaseDate', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findRandomMovie()
    {
        // On recupère la connexion à la BDD
        $conn = $this->getEntityManager()->getConnection();

        // On recherche les films, on les trie aléatoirement et on en garde qu'un 
        $sql = '
            SELECT * FROM movie m
            ORDER BY RAND() LIMIT 1
        ';

        // On execute la requête
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();

        // On récupère un tableau
        return $resultSet->fetchAssociative();
    }
}
