<?php

namespace BusinessBundle\Manager;

use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;

class BaseManager
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var ObjectRepository
     */
    protected $repository;

    /**
     * @param EntityManagerInterface $entityManager
     * @param string  $className
     */
    public function __construct(EntityManagerInterface $entityManager, string $className = null)
    {
        $this->entityManager = $entityManager;
        $className = !is_null($className) ? $className : $this->autoGuessClassName();
        $this->repository = $entityManager->getRepository($className);
    }

    /**
     * @return array
     */
    public function findAll()
    {
        return $this->repository->findAll();
    }

    /**
     * @param $id
     * @return null|object
     */
    public function find($id)
    {
        return $this->repository->find($id);
    }

    /**
     * Returns all entities for given criteria.
     *
     * @param array      $criteria
     * @param array|null $orderBy
     * @param int|null   $limit
     * @param int|null   $offset
     *
     * @return object[]
     */
    public function findBy(array $criteria, array $orderBy = null, int $limit = null, int $offset = null)
    {
        return $this->repository->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * Finds a single entity by a set of criteria.
     *
     * @param array $criteria
     *
     * @return object|null the entity instance or NULL if the entity can not be found
     */
    public function findOneBy(array $criteria)
    {
        return $this->repository->findOneBy($criteria);
    }

    /**
     * @param $entity
     * @param bool $doFlush
     * @return mixed
     */
    public function save($entity, $doFlush = true)
    {
        $this->entityManager->persist($entity);
        if ($doFlush) {
            $this->entityManager->flush();
        }

        return $entity;
    }

    /**
     * Delete the given entity.
     *
     * @param object $entity An entity instance
     */
    public function remove($entity)
    {
        $this->entityManager->remove($entity);
        $this->entityManager->flush();
    }

    /**
     * Return one entity by identifier.
     *
     * @param int $id
     *
     * @return object|null
     */
    public function findOneById(int $id)
    {
        return $this->repository->findOneBy(['id' => $id]);
    }

    /**
     * @return ObjectRepository
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * Flush persisted entities.
     */
    public function flush()
    {
        $this->entityManager->flush();
    }

    /**
     * Refresh persisted entities.
     *
     * @param object $entity
     */
    public function refresh($entity)
    {
        $this->entityManager->refresh($entity);
    }

    /**
     * Clears the repository, causing all managed entities to become detached.
     */
    public function clear()
    {
        $this->entityManager->clear();
    }


    /**
     * Auto-guesses the entity to use with this manager.
     *
     * If no class name has been provided, the manager will try to guess automatically
     * which entity class it should use.
     *
     * The auto-guess will search the entity as an interface first (which will later
     * be resolved to entity classes), and if it cannot find that, directly as a
     * class. It will use the name of the manager class as base for the entity to
     * use.
     *
     * The auto-guess is limited to the bundle in which the manager lives. The manager
     * has to be defined in the "Manager" folder and the entity/interface in the
     * "Entity" folder.
     *
     * For all exotic cases, it is possible to pass the class name directly as a
     * dependency.
     *
     * @throws \LogicException If using directly BaseManager as the manager of an entity, the entity must be provided explicitly
     * @throws \LogicException If the manager is not in the right location
     * @throws \LogicException If the corresponding entity/interface could not be found
     *
     * @return string
     */
    protected function autoGuessClassName()
    {
        if (__CLASS__ === get_class($this)) {
            throw new \LogicException(sprintf(
                'If using manager "%s" as a manager, you must provide a class name explicitly',
                __CLASS__
            ));
        }

        $matches = [];
        if (preg_match('#^(.*)\\\\Manager\\\\(\w+)Manager$#', get_class($this), $matches)) {
            list(, $bundlePath, $className) = $matches;

            $fullClassName = $bundlePath.'\\Entity\\'.$className;
            $interfaceName = $fullClassName.'Interface';

            if (interface_exists($interfaceName)) {
                return $interfaceName;
            }
            if (class_exists($fullClassName)) {
                return $fullClassName;
            }

            throw new \LogicException(sprintf(
                'Could not guess class name (tried to load interface "%s" then class "%s"). Check that the corresponding entity/interface is under the "Entity" folder of the same bundle than the manager. Alternatively, you can provide a class name explicitly to "%s".',
                $interfaceName, $fullClassName, get_class($this)
            ));
        }

        throw new \LogicException(sprintf(
            'Could not guess class name for manager "%s". Check that your manager is in the "Manager" folder. Alternatively, you can provide a class name explicitly',
            get_class($this)
        ));
    }

    /**
     * @return string
     */
    protected function getClassName()
    {
        return $this->repository->getClassName();
    }
}
