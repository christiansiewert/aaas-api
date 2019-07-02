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
use App\Entity\ServiceField;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\Util\ClassSourceManipulator;

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
    const ENTITY_NAMESPACE      = 'Aaas\\Entity\\';
    const REPOSITORY_NAMESPACE  = 'Aaas\\Repository\\';

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
        array_map([$this, 'buildRepository'], $project->getRepositories()->toArray());
    }

    /**
     * @param ProjectRepository $repository
     */
    public function buildRepository(ProjectRepository $repository)
    {
        array_map([$this, 'buildService'], $repository->getServices()->toArray());
    }

    /**
     * @param RepositoryService $service
     */
    public function buildService(RepositoryService $service)
    {
        $name             = $service->getName();
        $entityTargetPath = $this->generateClass($name);
        $sourceCode       = $this->generator->getFileContentsForPendingOperation($entityTargetPath);

        foreach ($service->getServiceFields() as $serviceField) {
            $sourceCode = $this->buildServiceField($serviceField, $sourceCode);
        }

        $this->generateClass($name, true);
        $this->generator->dumpFile($entityTargetPath, $sourceCode);
        $this->generator->writeChanges();
    }

    /**
     * Generates class target paths and adds them to
     * pending operations of our generator.
     *
     * @param string $name
     * @param bool $isRepository
     * @return string
     */
    public function generateClass(string $name, bool $isRepository = false) : string
    {
        $templateName = sprintf('doctrine/%s.tpl.php', $isRepository ? 'Repository' : 'Entity');
        $fqcn = $isRepository ? self::REPOSITORY_NAMESPACE . $name . 'Repository' : self::ENTITY_NAMESPACE . $name;

        return $this->generator->generateClass($fqcn, $templateName, array(
            'api_resource' => true,
            'entity_class_name' => $name,
            'entity_alias' => lcfirst($name)[0],
            'repository_full_class_name' => self::REPOSITORY_NAMESPACE . $name . 'Repository',
            'entity_full_class_name' => self::ENTITY_NAMESPACE . preg_split('/(?=[A-Z])/', $name)[1]
        ));
    }

    /**
     * Builds service fields and adds properties and getters/setters.
     *
     * @param ServiceField $serviceField
     * @param string $sourceCode
     * @return string
     */
    public function buildServiceField(ServiceField $serviceField, string $sourceCode) : string
    {
        $fieldName   = $serviceField->getName();
        $dataType    = $serviceField->getDataType();

        $manipulator = new ClassSourceManipulator($sourceCode);

        $options = [
            'fieldName' => $fieldName,
            'type' => $dataType,
            'options' => []
        ];

        if ($serviceField->getIsNullable() === true) {
            $options['nullable'] = true;
        }

        if ($serviceField->getIsUnique() === true) {
            $options['unique'] = true;
        }

        if ($dataType === 'string') {
            $options['length'] = $serviceField->getLength();
        } elseif ($dataType === 'float') {
            $options['precision'] = $serviceField->getDataTypePrecision();
            $options['scale'] = $serviceField->getDataTypeScale();
        }

        foreach ($serviceField->getOptions() as $fieldOption) {
            $options['options'][$fieldOption->getName()] = $fieldOption->getValue();
        }

        $manipulator->addEntityField($fieldName, $options);

        return $manipulator->getSourceCode();
    }
}
