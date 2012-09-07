<?php

namespace Digitas\Demo\DetaFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Digitas\Demo\Entity;

class DemoFixtures implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $user = new Entity\User();
        $user->setEmail('damien.pitard@digitas.fr');
        $manager->persist($user);
        
        $manager->flush();
    }
}