<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Provider\Base;

class UserFixtures extends BaseFixture
{
    public function loadData(ObjectManager $manager)
    {
        $user = new User();
        $user->setApiToken('test_api_key');
        $user->setEmail('test@example.com');
        $user->setPassword('test');
        $manager->persist($user);

        $manager->flush();
    }
}
