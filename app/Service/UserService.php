<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class UserService extends Service
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserRepository $userRepository
    ) {
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
    }

    /**
     * @param $email
     * @param bool $returnAsObject
     *
     * @return User
     */
    public function getUserByEmail($email, $returnAsObject = true)
    {
        $user = $this->userRepository->findByEmail($email, $returnAsObject);

        return $user;
    }

    /**
     * @param User $user
     *
     * @return User
     */
    public function save(User $user)
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }
}
