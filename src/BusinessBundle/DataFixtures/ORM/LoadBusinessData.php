<?php

namespace BusinessBundle\DataFixtures\ORM;

use BusinessBundle\Entity\ValueList;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

class LoadBusinessData extends Fixture implements ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;
    /**
     * @var string
     */
    private $file;

    private $logger;

    /**
     * @param ContainerInterface|null $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
        $this->logger = $this->container->get('ee.app.logger');
        $this->file = $this->container->getParameter('business_data_path');
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $batchSize = 20;
        $businessData = $this->getBusinessData();
        foreach ($businessData as $key => $value){

            $valueList = new ValueList();

            $valueList->setDomain($value['Domain']);
            $valueList->setKey($value['Key']);
            $valueList->setValue($value['Value']);
            $valueList->setEnable(false);

            $manager->persist($valueList);

            if ((($key + 1) % $batchSize) === 0) {
                $manager->flush();
                $manager->clear(); // Detaches all objects from Doctrine!
            }
        }
        $manager->flush(); //Persist objects that did not make up an entire batch
        $manager->clear();
    }

    /**
     * @return mixed
     */
    public function getBusinessData()
    {
        try{
            $datas = Yaml::parseFile($this->file);
        } catch (ParseException $exception){
            $this->logger->logError($exception->getMessage(), $exception);
            throw  $exception;
        }

        return  $datas;
    }
}