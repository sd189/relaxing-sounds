<?php

namespace App\Doctrine\ORM;

/**
 * Class AbstractEntityRepository.
 */
abstract class AbstractEntityRepository extends EntityRepository
{
    const LIMIT_DEFAULT = 10;
    const SORT_DEFAULT = 'id';
    const ORDER_DEFAULT = 'DESC';
    const PAGE_DEFAULT = 1;

    /**
     * @param array $options
     *
     * @return array
     */
    protected function checkPagination(array $options)
    {
        if (!isset($options['limit'])) {
            $options['limit'] = self::LIMIT_DEFAULT;
        } elseif (isset($options['limit']) && $options['limit'] == 0) {
            $options['limit'] = false;
        }

        if (!isset($options['sort'])) {
            $options['sort'] = self::SORT_DEFAULT;
        }

        if (!isset($options['order'])) {
            $options['order'] = self::ORDER_DEFAULT;
        }

        if (!isset($options['page'])) {
            $options['page'] = self::PAGE_DEFAULT;
        }

        return $options;
    }
}
