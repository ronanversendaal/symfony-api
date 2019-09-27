<?php

namespace App\Controller\Api;

use App\Entity\Page;
use App\Entity\Site;
use App\Repository\PageRepository;
use App\Repository\SiteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SiteController extends AbstractController
{

    /** @var EntityManagerInterface */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/site", name="api_site")
     */
    public function index()
    {

        /** @var PageRepository $pageRepository */
        $pageRepository = $this->entityManager->getRepository(Page::class);

        $siteRepository = $this->entityManager->getRepository(Site::class);

        /** @var Site $site */
        $site = $siteRepository->findOneBy([]);

        $rootNodes = $pageRepository->getRootNodes();

        $add = false;

        if($add) {
            $page = new Page();
            $page->setTitle('Test page in about');
            $page->setSlug('test');
            $page->setSite($site);

            $aboutUs = $pageRepository->findOneByTitle('About us');

            $pageRepository->persistAsFirstChildOf($page, $aboutUs);

            $this->entityManager->flush();
        }


        $treeHtml = $pageRepository->childrenHierarchy(null, false, /* true: load all children, false: only direct */
            array(
                'decorate' => true,
                'representationField' => 'slug',
                'html' => true
            ));

        echo($treeHtml);


        $tree = $pageRepository->childrenHierarchy(null);

        dd($tree, $rootNodes);

        return $this->render('api/site/index.html.twig', [
            'controller_name' => 'SiteController',
        ]);
    }
}
