<?php

namespace App\Repository;

use App\Doctrine\ORM\AbstractEntityRepository;
use Doctrine\ORM\AbstractQuery;

class SongRepository extends AbstractEntityRepository
{
    function entity() {
        return 'App\Entity\Song';
    }

    public function findSongs($filters)
    {
        $queryBuilder = $this->baseQuery($filters);

        $totalQb = clone $queryBuilder;
        $totalQb->select('count(song.id)');
        $data['total'] = $totalQb->getQuery()->getSingleScalarResult();

        $sort = 'song.' . $filters['sort'];

        $queryBuilder->setMaxResults($filters['limit'])
            ->setFirstResult(($filters['page'] - 1) * $filters['limit']);

        $queryBuilder->orderBy($sort, $filters['order']);

        $data['data'] = $queryBuilder->getQuery()->getArrayResult();

        return $data;
    }

    private function baseQuery($filters)
    {
        $queryBuilder = $this->createQueryBuilder('song')
            ->select('partial song.{id, name, link, categoryId, createdAt, updatedAt}')
            ->where('song.deletedAt is null');

        if ($this->hasOptionAndNotNull('name', $filters)) {
            $queryBuilder->andWhere('song.name LIKE :name')
                ->setParameter('name', '%'.$filters['name'].'%');
        }

        if ($this->hasOptionAndNotNull('categoryId', $filters)) {
            $queryBuilder->andWhere('song.categoryId = :categoryId')
                ->setParameter('categoryId', $filters['categoryId']);
        }

        return $queryBuilder;
    }
}
