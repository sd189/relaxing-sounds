<?php

namespace App\Service;

use App\Entity\Song;
use App\Repository\SongRepository;
use App\Utility\DateUtils;
use Doctrine\ORM\EntityManagerInterface;

class SongService extends Service
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var SongRepository
     */
    private $songRepository;

    /**
     * SongService constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param SongRepository $songRepository
     */
    public function __construct(EntityManagerInterface $entityManager, SongRepository $songRepository)
    {
        $this->entityManager = $entityManager;
        $this->songRepository = $songRepository;
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
            'categoryId' => null,
            'sort' => 'id',
            'limit' => '25',
            'page' => '1',
            'order' => 'ASC',
        ];
        $filters = array_merge($defaultFilters, $filters);

        $songs = $this->songRepository->findSongs($filters);
        array_walk($songs['data'], function (&$song) {
            $song['createdAt'] = DateUtils::dateToISO8601($song['createdAt']);
            $song['updatedAt'] = DateUtils::dateToISO8601($song['updatedAt']);
        });

        $results['meta'] = $this->createPaginationMeta($songs['total'], $filters['page'], $filters['limit']);
        $results['data'] = $songs['data'];

        return $results;
    }

    /**
     * @param $id
     *
     * @return null|object|Song
     */
    public function getSongObject($id)
    {
        return $this->songRepository->findOneBy(['id' => $id, 'deletedAt' => null]);
    }
}
