<?php

namespace BusinessBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use ApiSecurityBundle\Manager\BaseManager as BaseManager;

/**
 * Class AgendaManager
 */
class AgendaManager extends BaseManager
{
    protected $defaultLimit;
    protected $defaultOffset;

    /**
     * AgendaManager constructor.
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
    public function getAgendas($customerRef)
    {
        $agendas =  $this->repository->getAgendas($customerRef);

        return $agendas;
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
