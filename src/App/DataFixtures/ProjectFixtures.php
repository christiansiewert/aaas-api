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
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

/**
 * @author Christian Siewert <christian@sieware.international>
 */
class ProjectFixtures extends Fixture
{
    /**
     * Reference to our project fixture
     */
    public const PROJECT = 'project';

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $project = new Project();
        $project->setName('Webapplication');
        $project->setDescription('Our webapplication includes a shop, a website and an API. ');

        $manager->persist($project);
        $manager->flush();

        $this->addReference(self::PROJECT, $project);
    }
}