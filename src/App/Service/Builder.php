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
use App\Entity\Field;
use App\Entity\Repository;
use App\Entity\Service;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Bundle\MakerBundle\Doctrine\EntityRelation;
use Symfony\Bundle\MakerBundle\Util\ClassSourceManipulator;

/**
 * Builder builds source code from our project
 *
 * @author Christian Siewert <christian@sieware.international>
 *
 * @todo refactore
 */
class Builder
{
    /**
     * Namespaces to use for our generated entities and repositories
     */
    const ENTITY_NAMESPACE = 'Aaas\\Entity\\';
    const REPOSITORY_NAMESPACE = 'Aaas\\Repository\\';

    /**
     * @var Generator
     */
    private $generator;

    /**
     * @var KernelInterface
     */
    private $kernel;

    /**
     * @param Generator $generator
     * @param KernelInterface $kernel
     */
    public function __construct(Generator $generator, KernelInterface $kernel)
    {
        $this->generator = $generator;
        $this->kernel = $kernel;
    }

    /**
     * @param Project $project
     */
    public function buildProject(Project $project)
    {
        array_map([$this, 'buildRepository'], $project->getRepositories()->toArray());
    }

    /**
     * @param Repository $repository
     */
    public function buildRepository(Repository $repository)
    {
        array_map([$this, 'buildService'], $repository->getServices()->toArray());
    }

    /**
     * @param Service $service
     */
    public function buildService(Service $service)
    {
        $name = $service->getName();
        $type = $service->getType();

        $entityTargetPath = $type === Service::TYPE_LIST ?
            $this->generateClass($name) :
            $this->generateClass($name, false, true);

        $sourceCode = $this->generator->getFileContentsForPendingOperation($entityTargetPath);

        foreach ($service->getFields() as $serviceField) {
            $sourceCode = $this->buildServiceField($serviceField, $sourceCode);
        }

        $type === Service::TYPE_LIST ?
            $this->generateClass($name, true) :
            $this->generateClass($name, true, true) ;

        $this->generator->dumpFile($entityTargetPath, $sourceCode);
        $this->generator->writeChanges();
    }

    /**
     * Generates class target paths and adds them to pending operations of our generator.
     *
     * @param string $name
     * @param bool $isRepository
     * @param bool $isTree
     * @return string
     */
    public function generateClass(string $name, bool $isRepository = false, bool $isTree = false) : string
    {
        $format = dirname(__DIR__) . '/Resources/skeleton/doctrine/%s.tpl.php';
        $isTree !== true ?: $format = sprintf($format, 'Tree%s');
        $templateName = sprintf($format, $isRepository ? 'Repository' : 'Entity');
        $fqcn = $isRepository ? self::REPOSITORY_NAMESPACE . $name . 'Repository' : self::ENTITY_NAMESPACE . $name;

        return $this->generator->generateClass($fqcn, $templateName, array(
            'api_resource' => true,
            'entity_class_name' => $name,
            'entity_alias' => lcfirst($name)[0],
            'repository_full_class_name' => self::REPOSITORY_NAMESPACE . $name . 'Repository',
            'entity_full_class_name' => self::ENTITY_NAMESPACE . $name
        ));
    }

    /**
     * Adds an entity field to our manipulator and returns the generated source code.
     *
     * @param Field $serviceField
     * @param string $sourceCode
     * @return string
     */
    public function buildServiceField(Field $serviceField, string $sourceCode) : string
    {
        $name = $serviceField->getName();
        $dataType = $serviceField->getDataType();
        $manipulator = new ClassSourceManipulator($sourceCode);

        if ($dataType === 'relation') {
            return $this->buildFieldRelation($serviceField, $manipulator);
        }

        $options = [
            //'fieldName' => $name,
            'type' => $dataType,
            'options' => []
        ];

        $serviceField->getIsUnique() === false ?: $options['unique'] = true;
        $serviceField->getIsNullable() === false ?: $options['nullable'] = true;

        if ($dataType === 'string') {
            $options['length'] = $serviceField->getLength();
        } elseif ($dataType === 'float') {
            $options['precision'] = $serviceField->getDataTypePrecision();
            $options['scale'] = $serviceField->getDataTypeScale();
        }

        foreach ($serviceField->getOptions() as $fieldOption) {
            $options['options'][$fieldOption->getName()] = $fieldOption->getValue();
        }

        $manipulator->addEntityField($name, $options);

        return $manipulator->getSourceCode();
    }

    /**
     * Adds a field relation to our manipulator and returns the generated source code.
     *
     * @param Field $serviceField
     * @param ClassSourceManipulator $manipulator
     * @return string
     */
    public function buildFieldRelation(Field $serviceField, ClassSourceManipulator $manipulator) : string
    {
        $relation = $serviceField->getRelation();
        $relationType = $relation->getType();
        $inversedBy = $relation->getInversedBy();
        $owningClass = self::ENTITY_NAMESPACE . $serviceField->getService()->getName();
        $inverseClass = self::ENTITY_NAMESPACE . $relation->getTargetEntity();

        $entityRelation = new EntityRelation($relationType, $owningClass, $inverseClass);
        $entityRelation->setOwningProperty($serviceField->getName());
        $entityRelation->setIsNullable($serviceField->getIsNullable());
        $entityRelation->setMapInverseRelation(false);

        // @todo https://github.com/siewert87/aaas-api/issues/10
        /*if ($inversedBy !== null) {
            $entityRelation->setMapInverseRelation(true);
            $entityRelation->setInverseProperty($inversedBy);
        }*/

        if ($relationType === EntityRelation::ONE_TO_ONE) {
            $manipulator->addOneToOneRelation($entityRelation->getOwningRelation());
        } elseif ($relationType === EntityRelation::MANY_TO_ONE) {
            $manipulator->addManyToOneRelation($entityRelation->getOwningRelation());
        } elseif ($relationType === EntityRelation::ONE_TO_MANY) {
            $manipulator->addOneToManyRelation($entityRelation->getOwningRelation());
        } else {
            $manipulator->addManyToManyRelation($entityRelation->getOwningRelation());
        }

        return $manipulator->getSourceCode();
    }
}
