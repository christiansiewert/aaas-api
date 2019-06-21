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
     * @return Project
     */
    public function buildProject(Project $project)
    {
        $repositories = $project->getRepositories();

        foreach ($repositories as $repository) {
            $this->buildRepository($repository);
        }

        return $project;
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
        $name = $service->getName();

        $this->buildClass($name);
        $this->buildClass($name, true);

        // @todo get service fields and add them as properties to our entities

        $this->generator->writeChanges();
    }

    /**
     * Builds and dumps either an entity or an repository
     *
     * @param string $name
     * @param bool $isRepository
     */
    public function buildClass(string $name, bool $isRepository = false)
    {
        $template = sprintf('doctrine/%s.tpl.php', $isRepository ? 'Repository' : 'Entity');
        $fqcn = sprintf(self::NAMESPACE . '%s\\%s', $isRepository ? 'Repository' : 'Entity', $name);
        $fqcn = sprintf($fqcn . '%s', $isRepository ? 'Repository' : '');

        $targetPath = $this->generateTargetPath($fqcn, $name, $template);
        $this->generator->dumpFile($targetPath, $this->generator->getFileContentsForPendingOperation($targetPath));
    }

    /**
     * @param string $fqcn
     * @param string $className
     * @param string $templateName
     * @return string
     *
     * @todo refactore
     */
    public function generateTargetPath(string $fqcn, string $className, string $templateName)
    {
        $targetPath = null;

        try {
            $targetPath = $this->generator->generateClass(
                $fqcn,
                $templateName,
                array(
                    'api_resource' => true,
                    'repository_full_class_name' => self::NAMESPACE . 'Repository\\' . $className . 'Repository',
                    'entity_class_name' => $className,
                    'entity_full_class_name' => self::NAMESPACE . 'Entity\\' . $className,
                    'entity_alias' => lcfirst($className)[0]

                )
            );
        } catch (Exception $e) {
        }

        return $targetPath;
    }
}
