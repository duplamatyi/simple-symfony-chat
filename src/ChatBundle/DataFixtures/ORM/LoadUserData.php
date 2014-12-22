<?php

namespace ChatBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ChatBundle\Entity\User;


class LoadUserData implements FixtureInterface
{
    /**
    * {@inheritDoc}
    */
    public function load(ObjectManager $manager)
    {
        $user1 = new User();
        $user1->setUsername('user1');
        $manager->persist($user1);
        $user2 = new User();
        $user2->setUsername('user2');
        $manager->persist($user2);
        $manager->flush();
    }
}
