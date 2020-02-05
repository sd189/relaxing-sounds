<?php

namespace App\Service;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Utility\DateUtils;
use Doctrine\ORM\EntityManagerInterface;

class CategoryService extends Service
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * CategoryService constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(EntityManagerInterface $entityManager, CategoryRepository $categoryRepository)
    {
        $this->entityManager = $entityManager;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param $slug
     *
     * @return Category
     */
    public function getCategory($slug)
    {
        /** @var Category $category */
        $category = $this->categoryRepository->findBySlug($slug);
        if($category) {
            $category['createdAt'] = DateUtils::dateToISO8601($category['createdAt']);
            $category['updatedAt'] = DateUtils::dateToISO8601($category['updatedAt']);
        }

        return $category;
    }

    /**
     * @param $filters
     *
     * @return array
     */
    public function getAll($filters)
    {
        $defaultFilters = [
            'name' => null,
            'sort' => 'id',
            'limit' => '25',
            'page' => '1',
            'order' => 'ASC',
        ];
        $filters = array_merge($defaultFilters, $filters);

        $categories = $this->categoryRepository->findCategories($filters);
        array_walk($categories['data'], function (&$category) {
            $category['createdAt'] = DateUtils::dateToISO8601($category['createdAt']);
            $category['updatedAt'] = DateUtils::dateToISO8601($category['updatedAt']);
        });

        $results['meta'] = $this->createPaginationMeta($categories['total'], $filters['page'], $filters['limit']);
        $results['data'] = $categories['data'];

        return $results;
    }
}
