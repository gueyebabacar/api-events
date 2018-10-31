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
     * @param $userId
     * @return mixed
     */
    public function getUserEvents($userId)
    {
        $events =  $this->repository->getUserEvents($userId);

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

    /**
     * @param $id
     * @return mixed
     */
    public function getRegistrations($id)
    {
        $registrations =  $this->repository->getRegistrations($id);

        return $registrations;
    }
}
