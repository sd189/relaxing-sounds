<?php
/** base repository */
namespace App\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;

abstract class Repository extends EntityRepository
{
    public function __construct(EntityManager $entityManager)
    {
        $metadata = new ClassMetadata($this->entity());
        parent::__construct($entityManager, $metadata);
    }

    abstract function entity();

    public function createEntity(array $data)
    {
        $entity = new $this->_entityName;
        foreach ($data as $field => $value) {
            $methodName = 'set' . ucfirst($field);
            if (!method_exists($entity, $methodName)) {
                throw new RepositoryException('worng!');
            }
            $entity->$methodName($value);
        }
        $this->save($entity);

        return $entity;
    }

    protected function save($entity)
    {
        $this->_em->persist($entity);
        $this->_em->flush();
    }
}
