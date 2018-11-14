<?php

namespace BusinessBundle\Repository;

use BusinessBundle\Entity\Agenda;
use Doctrine\ORM\Query\Expr\Join;

/**
 * AgendaRepository
 *
 */
class AgendaRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @param $customerRef
     * @return \Doctrine\ORM\Query
     */
    public function getAgendas($customerRef)
    {
        $qb = $this->createQueryBuilder('a');

        $qb
            ->where('a.customerRef =:customerRef')
            ->setParameter('customerRef' ,$customerRef);

        //add sort
        $qb->add('orderBy', 'a.title asc');

        return $qb->getQuery();
    }
}
