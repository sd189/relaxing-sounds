<?php

namespace App\Doctrine\ORM;

use App\Repository\Repository;

/**
 * Class EntityRepository.
 */
abstract class EntityRepository extends Repository
{
    /**
     * @param $key
     * @param array $options
     *
     * @return bool
     */
    protected function hasOption($key, array $options)
    {
        return array_key_exists($key, $options);
    }

    /**
     * @param $key
     * @param array $options
     *
     * @return bool
     */
    protected function hasOptionAndNotNull($key, array $options)
    {
        return $this->hasOption($key, $options) && !is_null($options[$key]);
    }

    /**
     * @param $key
     * @param array $options
     *
     * @return bool
     */
    protected function hasOptionAndNotEmpty($key, array $options)
    {
        return $this->hasOption($key, $options) && !empty($options[$key]);
    }
}
