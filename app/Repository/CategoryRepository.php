<?php

namespace App\Repository;

use App\Doctrine\ORM\AbstractEntityRepository;
use Doctrine\ORM\AbstractQuery;

class CategoryRepository extends AbstractEntityRepository
{
    function entity() {
        return 'App\Entity\Category';
    }

    public function findBySlug($slug)
    {
        $queryBuilder = $this->createQueryBuilder('category')
            ->select('partial category.{id, name, slug, image, createdAt, updatedAt}')
            ->where('category.deletedAt is null')
            ->andWhere('category.slug = :slug')
            ->setParameter('slug', $slug);

        $category = $queryBuilder->getQuery()->getOneOrNullResult(AbstractQuery::HYDRATE_ARRAY);

        return $category;
    }

    public function findCategories($filters)
    {
        $queryBuilder = $this->baseQuery($filters);

        $totalQb = clone $queryBuilder;
        $totalQb->select('count(category.id)');
        $data['total'] = $totalQb->getQuery()->getSingleScalarResult();

        $sort = 'category.' . $filters['sort'];

        $queryBuilder->setMaxResults($filters['limit'])
            ->setFirstResult(($filters['page'] - 1) * $filters['limit']);

        $queryBuilder->orderBy($sort, $filters['order']);

        $data['data'] = $queryBuilder->getQuery()->getArrayResult();

        return $data;
    }

    private function baseQuery($filters)
    {
        $queryBuilder = $this->createQueryBuilder('category')
            ->select('partial category.{id, name, slug, image, createdAt, updatedAt}')
            ->where('category.deletedAt is null');

        if ($this->hasOptionAndNotNull('name', $filters)) {
            $queryBuilder->andWhere('category.name LIKE :name')
                ->setParameter('name', '%'.$filters['name'].'%');
        }

        return $queryBuilder;
    }
}
