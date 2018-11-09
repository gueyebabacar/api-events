<?php

namespace BusinessBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use BusinessBundle\Manager\BaseManager as BaseManager;

/**
 * Class ValueListManager
 */
class ValueListManager extends BaseManager
{
    protected $defaultLimit;
    protected $defaultOffset;

    /**
     * @var Request
     */
    protected $request;

    /**
     * ValueListManager constructor.
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
     * @return mixed
     */
    public function getValueLists($filterParams)
    {
        $valueLists =  $this->repository->getValueLists($filterParams);

        return $valueLists;
    }

}
