<?php

namespace ApiSecurityBundle\Repository;

/**
 * CustomerClientRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CustomerClientRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @param array $params
     * @return array
     */
    public function getCustomers(array $params)
    {
        $offset = !empty($params['offset']) ? $params['offset'] : $params['defaultOffset'];
        $limit = !empty($params['limit']) ? $params['limit'] : $params['defaultLimit'];
        $qb = $this->createQueryBuilder('c')
            ->setFirstResult($offset)
            ->setMaxResults($limit);

        return $qb->getQuery()->getResult();
    }
}