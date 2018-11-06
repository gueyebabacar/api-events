<?php

namespace ApiBundle\Service\Watcher;

use Doctrine\ORM\EntityManagerInterface;

class ArchivedEvent
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * ArchivedEvent constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function watcher(){
        try{
            $statement = $this->getConnection()->prepare("UPDATE `event` SET `status` = 'archived' WHERE `event`.`status` = 'published' AND `event`.`end_date` < DATE(NOW());");
            $statement->execute();

            return true;
        }catch (\Exception $exception){
            throw $exception;
        }
    }

    /**
     * @return \Doctrine\DBAL\Connection
     */
    public function getConnection()
    {
        return  $this->entityManager ->getConnection();
    }
}