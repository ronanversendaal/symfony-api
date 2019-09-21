<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ArticleFixtures extends BaseFixture
{
    public function loadData(ObjectManager $manager)
    {
        $this->createMany(Article::class, 10, function(Article $article) {

            $article->setTitle($this->faker->sentence);

            if($this->faker->boolean(70)) {
                $article->setPublishedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));
            }

            $article->setHasComments($this->faker->boolean(90));

            $article->setContent($this->faker->boolean(70) ? $this->faker->text() : $this->faker->sentences(10, true));
        });

        $manager->flush();
    }
}
