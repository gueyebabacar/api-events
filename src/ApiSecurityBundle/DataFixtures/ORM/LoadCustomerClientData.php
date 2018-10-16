<?php

namespace ApiSecurityBundle\DataFixtures\ORM;

use ApiSecurityBundle\Entity\CustomerClient;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;


class LoadCustomerClientData extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $customerClient1 = new CustomerClient();

        $customerClient1->setEnable(false);
        $customerClient1->setScopes(['ROLE_ADMIN']);
        $customerClient1->setXCustomerRef('admin_reader');

        $manager->persist($customerClient1);

        $customerClient2 = new CustomerClient();

        $customerClient2->setEnable(false);
        $customerClient2->setScopes(['ROLE_EDITOR']);
        $customerClient2->setXCustomerRef('editor_reader');

        $manager->persist($customerClient2);

        $customerClient3 = new CustomerClient();

        $customerClient3->setEnable(false);
        $customerClient3->setScopes(['ROLE_PUBLIC']);
        $customerClient3->setXCustomerRef('public_reader');

        $manager->persist($customerClient3);


        $manager->flush();
    }
}