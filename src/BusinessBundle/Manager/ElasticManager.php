<?php

namespace BusinessBundle\Manager;

use FOS\ElasticaBundle\Finder\FinderInterface;

/**
 * Class ElasticManager
 */
class ElasticManager
{
    protected $mapping = [
        'title' => '\Elastica\Query\Match',
        'city' => '\Elastica\Query\Match',
        'country' => '\Elastica\Query\Match',
        'organizer' => '\Elastica\Query\Match',
        'status' => '\Elastica\Query\Terms',
        'venue' => '\Elastica\Query\Match',
        'customer_ref' => '\Elastica\Query\Match',
        'industries' => '\Elastica\Query\Match'
    ];

    /**
     * ElasticManager constructor.
     * @param FinderInterface $finder
     */
    public function __construct(FinderInterface $finder)
    {
        $this->finder = $finder;
    }

    /**
     * @param $filterParams
     * @param $customerRef
     * @param $status
     * @return \Elastica\Query\BoolQuery
     */
    public function searchByElastic($filterParams, $customerRef, $status)
    {
        $boolQuery = new \Elastica\Query\BoolQuery();
        $filterParams['status'] = $status;
        $filterParams['customer_ref'] = $customerRef;

        foreach ($filterParams as $key => $value) {
            if ($key === "status"){
                $queryType = $this->mapping[$key];
                $statusQuery = new $queryType();
                $statusQuery->setTerms($key, $value);
                $boolQuery->addMust($statusQuery);
            }else{
                $queryType = $this->mapping[$key];
                $query = new $queryType();
                $query->setFieldQuery($key, $value);
                $boolQuery->addMust($query);
            }
        }

        return  $this->finder->find($boolQuery);
    }
}
