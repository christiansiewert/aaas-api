<?php

/*
 * This file is part of API as a Service.
 *
 * Copyright (c) 2019 Christian Siewert <christian@sieware.international>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\DataFixtures;

use App\Entity\Project;
use App\Entity\Repository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

/**
 * @author Christian Siewert <christian@sieware.international>
 */
class RepositoryFixtures extends Fixture
{
    /**
     * References to our repository fixtures
     */
    public const SHOP_REPOSITORY = 'shop-repository';
    public const SITE_REPOSITORY = 'site-repository';
    public const API_REPOSITORY  = 'api-repository';

    /**
     * @param ObjectManager $manager
     * @todo refactore
     */
    public function load(ObjectManager $manager)
    {
        /**
         * @var Project $project
         */
        $project = $this->getReference(ProjectFixtures::PROJECT);

        $shopRepository = new Repository();
        $shopRepository->setName('Shop repository');
        $shopRepository->setDescription('Our shop repository');

        $siteRepository = new Repository();
        $siteRepository->setName('Site repository');
        $siteRepository->setDescription('Out site repository');

        $apiRepository = new Repository();
        $apiRepository->setName('API repository');
        $apiRepository->setDescription('Out api repository');

        $project
            ->addRepository($shopRepository)
            ->addRepository($siteRepository)
            ->addRepository($apiRepository)
        ;

        $manager->persist($project);
        $manager->flush();

        $this->addReference(self::SHOP_REPOSITORY, $shopRepository);
        $this->addReference(self::SITE_REPOSITORY, $siteRepository);
        $this->addReference(self::API_REPOSITORY, $apiRepository);
    }

    /**
     * @return string[]
     */
    public function getDependencies()
    {
        return array(
            ProjectFixtures::class,
        );
    }
}