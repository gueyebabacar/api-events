<?php

namespace BusinessBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use ApiSecurityBundle\Manager\BaseManager as BaseManager;

/**
 * Class EventManager
 */
class EventManager extends BaseManager
{
    protected $defaultLimit;
    protected $defaultOffset;

    /**
     * EventManager constructor.
     * @param EntityManagerInterface $em
     * @param string $className
     * @param int $defaultLimit
     * @param int $defaultOffset
     */
    public function __construct(EntityManagerInterface $em, string $className, int $defaultLimit, int $defaultOffset)
    {
        parent::__construct($em, $className);
        $this->defaultLimit = $defaultLimit;
        $this->defaultOffset = $defaultOffset;
    }

    /**
     * @param $filterParams
     * @param $customerRef
     * @return mixed
     */
    public function getEvents($filterParams, $customerRef, $status)
    {
        $events =  $this->repository->getEvents($filterParams, $customerRef, $status);

        return $events;
    }

    /**
     * @return int|int
     */
    public function getDefaultLimit()
    {
        return $this->defaultLimit;
    }

    /**
     * @return int|int
     */
    public function getDefaultOffset()
    {
        return $this->defaultOffset;
    }
}
