<?php

namespace BusinessBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use BusinessBundle\Manager\BaseManager as BaseManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class TagManager
 */
class TagManager extends BaseManager
{
    protected $defaultLimit;
    protected $defaultOffset;
    protected $defaultPage;

    /**
     * @var Request
     */
    protected $request;

    /**
     * OpportunityManager constructor.
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
    public function getTags($paramFetcher)
    {
        $tags =  $this->repository->getTags([
            'offset'=>$paramFetcher->get('offset'),
            'limit'=>$paramFetcher->get('limit'),
            'domain'=>$paramFetcher->get('domain'),
            'defaultOffset'=>$this->defaultOffset,
            'defaultLimit'=>$this->defaultLimit
        ]);

        return $tags;
    }
}
