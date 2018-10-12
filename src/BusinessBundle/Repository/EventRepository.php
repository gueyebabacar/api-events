<?php

namespace BusinessBundle\Repository;

use BusinessBundle\Entity\Event;

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
            ->where('e.status !=:status')
            ->setParameter('status', Event::DELETE_STATUS)
            ->setFirstResult($offset)
            ->setMaxResults($limit);

        return $qb->getQuery()->getResult();
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getOneEvent($id)
    {
        $qb = $this->createQueryBuilder('e')
            ->where('e.id =:id')
            ->andWhere('e.status !=:status')
            ->setParameters(['id' => $id, 'status' => Event::DELETE_STATUS]);

        return $qb->getQuery()->getOneOrNullResult();
    }
}
