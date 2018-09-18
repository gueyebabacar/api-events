<?php

namespace BusinessBundle\Repository;

/**
 * EventRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EventRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @param array $params
     * @return array
     */
    public function getEvents(array $params)
    {
        $offset = !empty($params['offset']) ? $params['offset'] : $params['defaultOffset'];
        $limit = !empty($params['limit']) ? $params['limit'] : $params['defaultLimit'];
        $qb = $this->createQueryBuilder('e')
            ->setFirstResult($offset)
            ->setMaxResults($limit);

        return $qb->getQuery()->getResult();
    }
}
