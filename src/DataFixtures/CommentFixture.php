<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class CommentFixture extends BaseFixture implements DependentFixtureInterface
{
    public function getDependencies()
    {
        return [
            ArticleFixtures::class
        ];
    }

    public function loadData(ObjectManager $manager)
    {
        $this->createMany(Comment::class, 20, function (Comment $comment) {
            $comment->setBody('This is the body of comment');

            $article = $this->getRandomReference(Article::class);
            $comment->setArticle($article);
        });

        $manager->flush();
    }
}
