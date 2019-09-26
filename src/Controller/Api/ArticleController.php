<?php

namespace App\Controller\Api;

use App\Entity\Article;
use App\Service\ArticleService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route(
     *     name="count_articles",
     *     path="article/{id}/count",
     *     methods={"GET"},
     *     defaults={
     *       "_controller"="\App\Controller\Api\ArticleController::countCommentsinArticle",
     *       "_api_resource_class"="App\Entity\Article",
     *       "_api_item_operation_name"="countCommentsinArticle"
     *     }
     *   )
     * @param Article $data
     * @param ArticleService $articleService
     * @return JsonResponse
     */
    public function countCommentsinArticle(Article $data, ArticleService $articleService) {
        $commentCount = $articleService->countCommentsInArticle($data);
        return $this->json([
            'id' => $data->getId(),
            'comments_count' => $commentCount,
        ]);
    }

    /**
     * @Route("/article", name="article")
     */
    public function index(): Response
    {
        return $this->render('article/api/index.html.twig', [
            'controller_name' => 'ArticleController',
        ]);
    }
}
