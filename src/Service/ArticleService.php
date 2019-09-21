<?php namespace App\Service;

use App\Entity\Article;

class ArticleService
{
    public function countCommentsInArticle(Article $article): int
    {
        return $article->getComments()->count();
    }

}