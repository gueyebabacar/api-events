<?php

namespace BusinessBundle\Manager;

use FOS\ElasticaBundle\Finder\FinderInterface;

/**
 * Class ElasticManager
 */
class ElasticValueListManager
{
    protected $defaultLimit;
    protected $defaultOffset;

    protected $mapping = [
        'domain' => '\Elastica\Query\Match'
    ];

    /**
     * ElasticValueListManager constructor.
     * @param FinderInterface $finder
     * @param int $defaultLimit
     * @param int $defaultOffset
     */
    public function __construct(FinderInterface $finder, int $defaultLimit, int $defaultOffset)
    {
        $this->finder = $finder;
        $this->defaultLimit = $defaultLimit;
        $this->defaultOffset = $defaultOffset;
    }

    /**
     * @param $filterParams
     * @return array
     */
    public function searchByElastic($filterParams)
    {
        $boolQuery = new \Elastica\Query\BoolQuery();

        if(!empty($filterParams['domain'])) {
            $queryType = $this->mapping['domain'];
            $query = new $queryType();
            $query->setFieldQuery('domain', $filterParams['domain']);
            $boolQuery->addShould($query);
        }

        return  $this->finder->find($boolQuery);
    }

    /**
     * @return int|int
     */
    public function getDefaultLimit()
    {
        return $this->defaultLimit;
    }

    /**
     * @param int|int $defaultLimit
     */
    public function setDefaultLimit($defaultLimit)
    {
        $this->defaultLimit = $defaultLimit;
    }

    /**
     * @return int|int
     */
    public function getDefaultOffset()
    {
        return $this->defaultOffset;
    }

    /**
     * @param int|int $defaultOffset
     */
    public function setDefaultOffset($defaultOffset)
    {
        $this->defaultOffset = $defaultOffset;
    }
}
