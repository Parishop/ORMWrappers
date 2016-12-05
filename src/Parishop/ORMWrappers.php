<?php
namespace Parishop;

/**
 * Class ORMWrappers
 * @package Parishop
 * @since   1.0.1
 */
abstract class ORMWrappers extends \PHPixie\ORM\Wrappers\Implementation
{
    /**
     * @var \PHPixie\DefaultBundle\Builder
     * @since 1.0.1
     */
    protected $builder;

    /**
     * Wrappers constructor.
     * @param \PHPixie\DefaultBundle\Builder $builder
     * @since 1.0.1
     */
    public function __construct($builder)
    {
        $this->builder              = $builder;
        $this->databaseEntities     = array_map('lcfirst', array_map('basename', glob($this->path() . '/ORMWrappers/*', GLOB_ONLYDIR)));
        $this->databaseQueries      = $this->databaseEntities;
        $this->databaseRepositories = $this->databaseEntities;
    }

    /**
     * @param \PHPixie\ORM\Drivers\Driver\PDO\Query $query
     * @return ORMWrappers\Query
     * @since 1.0.1
     */
    public function databaseQueryWrapper($query)
    {
        $className = get_class($this) . '\\' . ucfirst($query->modelName()) . '\Query';
        if(class_exists($className)) {
            return new $className($query);
        }

        return new ORMWrappers\Query($query);
    }

    /**
     * @param \PHPixie\ORM\Drivers\Driver\PDO\Repository $repository
     * @return ORMWrappers\Repository
     * @since 1.0.1
     */
    public function databaseRepositoryWrapper($repository)
    {
        $className = get_class($this) . '\\' . ucfirst($repository->modelName()) . '\Repository';
        if(class_exists($className)) {
            return new $className($repository, $this->builder);
        }

        return new ORMWrappers\Repository($repository, $this->builder);
    }

    /**
     * @param \PHPixie\ORM\Drivers\Driver\PDO\Entity $entity
     * @return ORMWrappers\Entity
     * @since 1.0.1
     */
    protected function entityWrapper($entity)
    {
        $className = get_class($this) . '\\' . ucfirst($entity->modelName()) . '\Entity';
        if(class_exists($className)) {
            return new $className($entity);
        }

        return new ORMWrappers\Entity($entity);
    }

    protected abstract function path();

}

