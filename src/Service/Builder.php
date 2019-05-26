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
use Exception;

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
    const NAMESPACE = 'Aaas\\';

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
    public function buildProject(Project $project)
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
        $className = $service->getName();
        $fqcn = self::NAMESPACE . 'Entity\\' . $className;
        $targetPath = $this->generateTargetPath($fqcn, $className);
        $this->generator->dumpFile($targetPath, $this->generator->getFileContentsForPendingOperation($targetPath));
        $this->generator->writeChanges();
    }

    /**
     * @param string $fqcn
     * @param string $className
     * @return string
     */
    public function generateTargetPath(string $fqcn, string $className)
    {
        $targetPath = null;

        try {

            $targetPath = $this->generator->generateClass(
                $fqcn,
                'doctrine/Entity.tpl.php',
                array(
                    'api_resource' => true,
                    'repository_full_class_name' => self::NAMESPACE . 'Repository\\' . $className . 'Repository'
                )
            );

        } catch (Exception $e) { }

        return $targetPath;
    }
}