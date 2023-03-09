<?php

namespace App\Infrastructure\Doctrine\Repository;

use App\Domain\Entity\MatchGame;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MatchGame|null find($id, $lockMode = null, $lockVersion = null)
 * @method MatchGame|null findOneBy(array $criteria, array $orderBy = null)
 * @method MatchGame[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MatchGameRepository extends ServiceEntityRepository implements \App\Domain\Repository\MatchGameRepository
{
    public const BASE_ALIAS = "match_game";
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MatchGame::class);
    }

    /**
     * {@inheritDoc}
     */
    public function create(MatchGame $matchGame): void
    {
        $this->_em->persist($matchGame);
        $this->_em->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function findAllByTeamOrNull(?string $teamUuid): array
    {
        $query = $this->createQueryBuilder(self::BASE_ALIAS);
        if ($teamUuid !== null) {
            self::addTeamConstraint($query, $teamUuid, self::BASE_ALIAS);
        }
        return $query->getQuery()->getResult();
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param string $uuid
     * @param string $matchAlias
     * @return QueryBuilder
     */
    public static function addTeamConstraint(
        QueryBuilder $queryBuilder,
        string $uuid,
        string $matchAlias = self::BASE_ALIAS
    ): QueryBuilder {
        return $queryBuilder->andWhere("$matchAlias.homeTeam = :teamUuid OR $matchAlias.visitorTeam = :teamUuid")
            ->setParameter('teamUuid', $uuid);
    }
}