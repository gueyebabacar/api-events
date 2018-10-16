<?php

namespace BusinessBundle\Service;

use BusinessBundle\Manager\ValueListManager;
use BusinessBundle\Entity\ValueList;

class ImportBusinessDataService
{
    private $valueListManager;

    public function __construct(ValueListManager $valueListManager)
    {
        $this->valueListManager = $valueListManager;
    }

    public function import($filePath){

        if (($handle = fopen($filePath , "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $valueList = new ValueList();

                $valueList->setDomain($data[0]);
                $valueList->setKey($data[1]);
                $valueList->setValue($data[2]);
                $valueList->setEnable(false);

                $this->valueListManager->save($valueList);

            }
            fclose($handle);
        }
        return true;
    }
}