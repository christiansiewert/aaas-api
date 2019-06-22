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
     * Namespaces to use for our generated entities and repositories
     */
    const BASE_NAMESPACE        = 'Aaas\\';
    const ENTITY_NAMESPACE      = self::BASE_NAMESPACE . 'Entity\\';
    const REPOSITORY_NAMESPACE  = self::BASE_NAMESPACE . 'Repository\\';

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
        $templateName = sprintf('doctrine/%s.tpl.php', $isRepository ? 'Repository' : 'Entity');
        $fqcn = $isRepository ? self::REPOSITORY_NAMESPACE . $name . 'Repository' : self::ENTITY_NAMESPACE . $name;

        $targetPath = $this->generateClassTargetPath($fqcn, $templateName);
        $this->generator->dumpFile($targetPath, $this->generator->getFileContentsForPendingOperation($targetPath));
    }

    /**
     * Generates target path for entities and repositories
     *
     * @param string $fqcn
     * @param string $templateName
     * @return string
     */
    public function generateClassTargetPath(string $fqcn, string $templateName)
    {
        $className  = explode('\\', $fqcn);
        $className  = end($className);

        return $this->generator->generateClass($fqcn, $templateName, array(
            'api_resource' => true,
            'entity_class_name' => $className,
            'entity_alias' => lcfirst($className)[0],
            'repository_full_class_name' => self::REPOSITORY_NAMESPACE . $className . 'Repository',
            'entity_full_class_name' => self::ENTITY_NAMESPACE . preg_split('/(?=[A-Z])/', $className)[1]
        ));
    }
}
