<?php

namespace Tourze\JsonRPCCallerBundle\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Tourze\JsonRPCCallerBundle\Entity\ApiCaller;

class ApiCallerFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $caller = new ApiCaller();
        $caller->setTitle('默认应用');
        $caller->setAppId(bin2hex(random_bytes(16)));
        $caller->setAppSecret(bin2hex(random_bytes(16)));
        $caller->setSignTimeoutSecond(1800);
        $caller->setValid(true);
        $manager->persist($caller);

        $manager->flush();
    }
}
