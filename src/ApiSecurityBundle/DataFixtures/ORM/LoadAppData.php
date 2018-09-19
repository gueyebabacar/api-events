<?php

namespace ApiSecurityBundle\DataFixtures\ORM;

use ApiSecurityBundle\Entity\AppClient;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


class LoadAppData extends Fixture implements  ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $passwordEncoder = $this->container->get('security.password_encoder');
        for ($i = 1; $i < 4; $i++) {
            $app = new AppClient();
            $password = $passwordEncoder->encodePassword($app, 'test');
            $app->setEnable(false);
            $app->setLogin('login'.$i);
            $app->setPwd($password);
            $manager->persist($app);
        }
        $manager->flush();
    }
}