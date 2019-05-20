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
 * Builder builds source code from our project
 *
 * @author Christian Siewert <christian@sieware.international>
 */
class Builder
{
    /**
     * Namespace to use for our generated entities
     */
    const NAMESPACE = 'App\Entity\\';

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
        $targetPath = $this->generateTargetPath(self::NAMESPACE . $service->getName());
        $dumpPath = str_replace('src', 'build', $targetPath);
        $this->generator->dumpFile($dumpPath, $this->generator->getFileContentsForPendingOperation($dumpPath));
        $this->generator->writeChanges();
    }

    /**
     * @param string $className
     */
    public function generateTargetPath(string $className)
    {
        return $this->generator->generateClass(
            $className,
            'doctrine/Entity.tpl.php',
            array(
                'namespace' => self::NAMESPACE,
                'api_resource' => true,
                'repository_full_class_name' => $className
            )
        );
    }
}