<?php

namespace App\DataFixtures;

use App\Entity\Page;
use App\Entity\Site;
use App\Repository\PageRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class PageFixtures extends BaseFixture implements DependentFixtureInterface
{
    public function getDependencies()
    {
        return [
            SiteFixtures::class
        ];
    }

    public function loadData(ObjectManager $manager)
    {
        /** @var Site $site */
        $site = $manager->getRepository(Site::class)->findOneBy([]);

        $rootPage = new Page();
        $rootPage->setTitle('Root Page');
        $rootPage->setSlug('');
        $rootPage->setSite($site);

        $homePage = new Page();
        $homePage->setTitle('Home Page');
        $homePage->setSlug('/');
        $homePage->setSite($site);

        $aboutUs = new Page();
        $aboutUs->setTitle('About us');
        $aboutUs->setSlug('/about-us');
        $aboutUs->setSite($site);

        /** @var PageRepository $pageRepository */
        $pageRepository = $manager->getRepository(Page::class);

        $pageRepository->persistAsFirstChild($rootPage);
        $pageRepository->persistAsFirstChildOf($homePage, $rootPage);
        $pageRepository->persistAsFirstChildOf($aboutUs, $rootPage);

        $manager->flush();
    }
}
