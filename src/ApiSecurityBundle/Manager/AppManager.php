<?php

namespace ApiSecurityBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use ApiSecurityBundle\Manager\BaseManager as BaseManager;

/**
 * Class AppManager
 */
class AppManager extends BaseManager
{
    protected $defaultLimit;
    protected $defaultOffset;
    protected $defaultPage;

    /**
     * @var Request
     */
    protected $request;

    /**
     * AppManager constructor.
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
    public function getApps($paramFetcher)
    {
        $apps =  $this->repository->getApps([
            'offset'=>$paramFetcher->get('offset'),
            'limit'=>$paramFetcher->get('limit'),
            'defaultOffset'=>$this->defaultOffset,
            'defaultLimit'=>$this->defaultLimit
        ]);

        return $apps;
    }

    /**
     * @param $paramFetcher
     * @return mixed
     */
    public function getAppByLogin($request)
    {
        $apps =  $this->repository->getAppByLogin($request);

        return $apps;
    }
}
