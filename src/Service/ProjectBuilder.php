<?php

/*
 * This file is part of API as a Service.
 *
 * Copyright (c) 2019 Christian Siewert <christian@sieware.international>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service;

use App\Entity\Project;
use App\Entity\ProjectRepository;
use App\Entity\RepositoryService;
use Symfony\Bundle\MakerBundle\Generator;

/**
 * Project builder builds source code from our project
 *
 * @author Christian Siewert <christian@sieware.international>
 *
 * @todo refactor
 */
class ProjectBuilder
{
    /**
     * @var Generator
     */
    private $generator;

    /**
     * @param Generator $generator
     */
    public function __construct(Generator $generator)
    {
        $this->generator = $generator;
    }

    /**
     * @param Project $project
     */
    public function build(Project $project)
    {
        $repositories = $project->getRepositories();

        foreach ($repositories as $repository) {
            $this->buildRepository($repository);
        }

        $this->generator->writeChanges();
    }

    /**
     * @param ProjectRepository $repository
     */
    public function buildRepository(ProjectRepository $repository)
    {
        $services = $repository->getServices();

        foreach ($services as $service) {
            $this->buildService($service);
        }
    }

    /**
     * @param RepositoryService $service
     */
    public function buildService(RepositoryService $service)
    {
        $targetPath = $this->generator->generateClass(
            sprintf('App\Entity\%s', $service->getName()),
            'doctrine/Entity.tpl.php',
            array(
                'namespace' => 'App\Entity',
                'api_resource' => true,
                'repository_full_class_name' => sprintf('App\Entity\%s', $service->getName())
            )
        );

        $dumpPath = str_replace('src', 'build', $targetPath);

        $this->generator->dumpFile($dumpPath, $this->generator->getFileContentsForPendingOperation($targetPath));
    }
}