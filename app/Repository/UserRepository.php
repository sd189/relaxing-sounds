<?php

namespace App\Repository;

use App\Doctrine\ORM\AbstractEntityRepository;
use App\Entity\User;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Query\Expr\Join;

class UserRepository extends AbstractEntityRepository
{
    function entity() {
        return 'App\Entity\User';
    }

    public function findByEmail($email, $returnAsObject = true)
    {
        $queryBuilder = $this->createQueryBuilder('user')
            ->select('partial user.{id, name, email, jwtAccessToken, createdAt, updatedAt}')
            ->where('user.deletedAt is null')
            ->andWhere('user.email = :email')
            ->setParameter('email', $email);

        if ($returnAsObject) {
            $user = $queryBuilder->getQuery()->getOneOrNullResult();
        } else {
            $user = $queryBuilder->getQuery()->getOneOrNullResult(AbstractQuery::HYDRATE_ARRAY);
        }

        return $user;
    }
}
