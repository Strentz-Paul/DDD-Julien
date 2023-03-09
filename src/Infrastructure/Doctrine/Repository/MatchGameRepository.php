<?php

namespace App\Infrastructure\Doctrine\Repository;

use App\Domain\Entity\MatchGame;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MatchGame|null find($id, $lockMode = null, $lockVersion = null)
 * @method MatchGame|null findOneBy(array $criteria, array $orderBy = null)
 * @method MatchGame[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MatchGameRepository extends ServiceEntityRepository implements \App\Domain\Repository\MatchGameRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MatchGame::class);
    }

    public function create(MatchGame $matchGame): void
    {
        $this->_em->persist($matchGame);
        $this->_em->flush();
    }
}