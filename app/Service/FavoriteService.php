<?php

namespace App\Service;

use App\Entity\Favorite;
use App\Repository\FavoriteRepository;
use App\Utility\DateUtils;
use Doctrine\ORM\EntityManagerInterface;

class FavoriteService extends Service
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var FavoriteRepository
     */
    private $favoriteRepository;

    /**
     * FavoriteService constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param FavoriteRepository $favoriteRepository
     */
    public function __construct(EntityManagerInterface $entityManager, FavoriteRepository $favoriteRepository)
    {
        $this->entityManager = $entityManager;
        $this->favoriteRepository = $favoriteRepository;
    }

    /**
     * @param $filters
     *
     * @return array
     */
    public function getAll($filters)
    {
        $defaultFilters = [
            'sessionId' => null,
            'songId' => null,
            'categoryId' => null,
            'sort' => 'id',
            'limit' => '25',
            'page' => '1',
            'order' => 'ASC',
        ];
        $filters = array_merge($defaultFilters, $filters);

        $favorites = $this->favoriteRepository->findFavorites($filters);
        array_walk($favorites['data'], function (&$favorite) {
            $favorite['createdAt'] = DateUtils::dateToISO8601($favorite['createdAt']);
            $favorite['updatedAt'] = DateUtils::dateToISO8601($favorite['updatedAt']);
        });

        $results['meta'] = $this->createPaginationMeta($favorites['total'], $filters['page'], $filters['limit']);
        $results['data'] = $favorites['data'];

        return $results;
    }

    /**
     * @param Favorite $favorite
     *
     * @return Favorite
     */
    public function save(Favorite $favorite)
    {
        $this->entityManager->persist($favorite);
        $this->entityManager->flush();

        return $favorite;
    }
}
