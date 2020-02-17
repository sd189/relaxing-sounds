<?php

namespace App\Repository;

use App\Doctrine\ORM\AbstractEntityRepository;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Query\Expr\Join;

class FavoriteRepository extends AbstractEntityRepository
{
    function entity() {
        return 'App\Entity\Favorite';
    }

    public function findFavorites($filters)
    {
        $queryBuilder = $this->baseQuery($filters);

        $totalQb = clone $queryBuilder;
        $totalQb->select('count(favorite.id)');
        $data['total'] = $totalQb->getQuery()->getSingleScalarResult();

        $sort = 'favorite.' . $filters['sort'];

        $queryBuilder->setMaxResults($filters['limit'])
            ->setFirstResult(($filters['page'] - 1) * $filters['limit']);

        $queryBuilder->orderBy($sort, $filters['order']);

        $data['data'] = $queryBuilder->getQuery()->getArrayResult();

        return $data;
    }

    private function baseQuery($filters)
    {
        $queryBuilder = $this->createQueryBuilder('favorite')
            ->select('partial favorite.{id, sessionId, songId, createdAt, updatedAt},
                partial song.{id, name, categoryId}')
            ->where('favorite.deletedAt is null')
            ->leftJoin('favorite.song', 'song');

        if ($this->hasOptionAndNotNull('sessionId', $filters)) {
            $queryBuilder->andWhere('favorite.sessionId = :sessionId')
                ->setParameter('sessionId', $filters['sessionId']);
        }

        if ($this->hasOptionAndNotNull('songId', $filters)) {
            $queryBuilder->andWhere('favorite.songId = :songId')
                ->setParameter('songId', $filters['songId']);
        }

        if ($this->hasOptionAndNotNull('categoryId', $filters)) {
            $queryBuilder->andWhere('song.categoryId = :categoryId')
                ->setParameter('categoryId', $filters['categoryId']);
        }

        return $queryBuilder;
    }
}
