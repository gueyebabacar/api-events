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
     * @param $paramFetcher
     * @return mixed
     */
    public function getEvents($paramFetcher)
    {
        $events =  $this->repository->getEvents([
            'offset'=>$paramFetcher->get('offset'),
            'limit'=>$paramFetcher->get('limit'),
            'defaultOffset'=>$this->defaultOffset,
            'defaultLimit'=>$this->defaultLimit
        ]);

        return $events;
    }
}
