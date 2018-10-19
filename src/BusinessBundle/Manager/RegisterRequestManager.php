<?php

namespace BusinessBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use ApiSecurityBundle\Manager\BaseManager as BaseManager;

/**
 * Class RegisterRequestManager
 */
class RegisterRequestManager extends BaseManager
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
     * @param $userId
     * @return mixed
     */
    public function getUserEvents($paramFetcher, $userId)
    {
        $defaultLimit = $this->getDefaultLimit();
        $defaultOffset = $this->getDefaultOffset();
        $limit = (empty($paramFetcher->get('limit'))) ? $defaultLimit : $paramFetcher->get('limit');
        $offset = (empty($paramFetcher->get('offset'))) ? $defaultOffset : $paramFetcher->get('offset');
        $events =  $this->repository->getUserEvents($limit, $offset, $userId);

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
