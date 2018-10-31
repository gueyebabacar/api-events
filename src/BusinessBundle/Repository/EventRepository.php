<?php

namespace BusinessBundle\Repository;

use BusinessBundle\Entity\Event;
use Doctrine\ORM\Query\Expr\Join;

/**
 * EventRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EventRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @param $filterParams
     * @param $customerRef
     * @param $status
     * @return \Doctrine\ORM\Query
     */
    public function getEvents($filterParams, $customerRef, $status)
    {
        $industries = (array_key_exists('industries', $filterParams)) ? explode(",", $filterParams['industries']) : [];
        $eventType = (array_key_exists('eventType', $filterParams)) ? explode(",", $filterParams['eventType']) : [];
        $eventTopic = (array_key_exists('eventTopic', $filterParams)) ? explode(",", $filterParams['eventTopic']) : [];
        $venue = (array_key_exists('venue', $filterParams)) ? explode(",", $filterParams['venue']) : [];

        $qb = $this->createQueryBuilder('e')
            ->leftJoin('e.industries', 'i')
            ->leftJoin('e.eventType', 'type')
            ->leftJoin('e.eventTopic', 'topic');
        if(array_key_exists('connectedUser', $filterParams)){
            $qb
                ->addSelect('req')
                ->leftJoin('e.requestRegisters', 'req', Join::WITH, $qb->expr()->eq('req.userId', ':userId'))
                ->setParameter('userId', $filterParams['connectedUser']);
        }
        $qb
            ->where('e.status IN (:status) AND e.customerRef =:customerRef')
            ->setParameter('status',$status)
            ->setParameter('customerRef' ,$customerRef);

        foreach ($filterParams as $key => $value) {
            switch ($key) {
                case "title":
                    $qb
                        ->andWhere('e.title LIKE :title')
                        ->setParameter('title', $value);
                    break;
                case "organizer":
                    $qb
                        ->andWhere('e.organizer LIKE :organizer')
                        ->setParameter('organizer', $value);
                    break;
                case "status":
                    $qb
                        ->andWhere('e.status LIKE :status')
                        ->setParameter('status', $value);
                    break;
                case "createdAtFrom":
                    if(!array_key_exists('createdAtTo', $filterParams)){
                        $qb
                            ->andWhere('e.createdAt >= :createdAtFrom')
                            ->setParameter('createdAtFrom', $value);
                    }
                    break;
                case "createdAtTo":
                    if(!array_key_exists('createdAtFrom', $filterParams)){
                        $qb
                            ->andWhere('e.createdAt <= :createdAtTo')
                            ->setParameter('createdAtTo', $value);
                    }
                    break;
                case "eventDateFrom":
                    if(!array_key_exists('eventDateTo', $filterParams)){
                        $qb
                            ->andWhere('e.startDate >=:eventDateFrom')
                            ->setParameter('eventDateFrom', $value);
                    }
                    break;
                case "eventDateTo":
                    if(!array_key_exists('eventDateFrom', $filterParams)){
                        $qb
                            ->andWhere('e.startDate <= :eventDateTo')
                            ->setParameter('eventDateTo', $value);
                    }
                    break;
            }
        }

        if (!empty($industries)) {
            $qb
                ->andWhere('i.id IN (:industries)')
                ->setParameter('industries', $industries);
        }

        if (!empty($eventType)) {
            $qb
                ->andWhere('type.id IN (:eventType)')
                ->setParameter('eventType', $eventType);
        }

        if (!empty($eventTopic)) {
            $qb
                ->andWhere('topic.id IN (:eventTopic)')
                ->setParameter('eventTopic', $eventTopic);
        }

        if (!empty($venue)) {
            $qb
                ->andWhere('e.venue IN (:venue)')
                ->setParameter('venue', $venue);
        }

        if (array_key_exists('eventDateFrom', $filterParams) && array_key_exists('eventDateTo', $filterParams)) {
            $qb
                ->andWhere('e.startDate >= :eventDateFrom AND e.startDate <= :eventDateTo')
                ->setParameter( 'eventDateFrom', $filterParams['eventDateFrom'])
                ->setParameter( 'eventDateTo', $filterParams['eventDateTo']);
        }

        if (array_key_exists('createdAtFrom', $filterParams) && array_key_exists('createdAtTo', $filterParams)) {
            $qb
                ->andWhere('e.createdAt >=:createdAtFrom AND e.createdAt <=:createdAtTo')
                ->setParameter( 'createdAtFrom', $filterParams['createdAtFrom'])
                ->setParameter( 'createdAtTo', $filterParams['createdAtTo']);
        }

        //add sort
        if (isset($filterParams['sortBy'])) {
            $qb->add('orderBy', 'e.'.$filterParams['sortBy'].' ' . $filterParams['sortDir']);
        }

        return $qb->getQuery();
    }
}
