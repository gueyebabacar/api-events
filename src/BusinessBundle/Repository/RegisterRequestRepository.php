<?php

namespace BusinessBundle\Repository;

/**
 * RegisterRequestRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class RegisterRequestRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @param $userId
     * @return \Doctrine\ORM\Query
     */
    public function getUserEvents($userId)
    {
        $qb = $this->createQueryBuilder('r')
            ->where("r.userId =:userId")
            ->setParameter('userId', $userId);


        return $qb->getQuery();
    }

    /**
     * @param $id
     * @return \Doctrine\ORM\Query
     */
    public function getRegistrations($id)
    {
        $qb = $this->createQueryBuilder('r')
            ->addSelect('ev')
            ->leftJoin('r.event', 'ev')
            ->where('ev.id  =:id')
            ->setParameter( 'id', $id);

        return $qb->getQuery();
    }
}
