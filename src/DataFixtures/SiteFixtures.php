<?php

namespace App\DataFixtures;

use App\Entity\Site;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class SiteFixtures extends BaseFixture
{
    public function loadData(ObjectManager $manager)
    {
        $this->createMany(Site::class, 1, function(Site $site) {
            $site->setTitle($this->faker->realText(64));

            $site->setHost($this->faker->ipv4);
        });

        $manager->flush();
    }
}
