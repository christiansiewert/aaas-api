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

    /**
     * @var ClassGenerator
     */
    private $classGenerator;

    /**
     * @param ClassGenerator $classGenerator
     */
    public function __construct(ClassGenerator $classGenerator)
    {
        $this->classGenerator = $classGenerator;
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
        $this->classGenerator->generateRepositoryClass($service);
        $entityTargetPath = $this->classGenerator->generateEntityClass($service);
        $sourceCode = $this->classGenerator->generator->getFileContentsForPendingOperation($entityTargetPath);

        foreach ($service->getFields() as $field) {
            $sourceCode = $this->buildfield($field, $sourceCode);
        }

        $this->classGenerator->generator->dumpFile($entityTargetPath, $sourceCode);
        $this->classGenerator->generator->writeChanges();
    }

    /**
     * Adds an entity field to our manipulator and returns the generated source code.
     *
     * @param Field $field
     * @param string $sourceCode
     * @return string
     */
    public function buildfield(Field $field, string $sourceCode) : string
    {
        $dataType = $field->getDataType();
        $manipulator = new ClassSourceManipulator($sourceCode);

        if ($dataType === 'relation') {
            return $this->buildFieldRelation($field, $manipulator);
        }

        $options = ['type' => $dataType];
        $field->getIsUnique() === false ?: $options['unique'] = true;
        $field->getIsNullable() === false ?: $options['nullable'] = true;

        if ($dataType === 'string') {
            $options['length'] = $field->getLength();
        } elseif ($dataType === 'decimal') {
            $options['precision'] = $field->getDataTypePrecision();
            $options['scale'] = $field->getDataTypeScale();
        }

        if ($field->getOptions()->count() > 0) {
            $options['options'] = [];
            foreach ($field->getOptions() as $fieldOption) {
                $options['options'][$fieldOption->getName()] = $fieldOption->getValue();
            }
        }

        $manipulator->addEntityField($field->getName(), $options);

        return $manipulator->getSourceCode();
    }

    /**
     * Adds a field relation to our manipulator and returns the generated source code.
     *
     * @param Field $field
     * @param ClassSourceManipulator $manipulator
     * @return string
     */
    public function buildFieldRelation(Field $field, ClassSourceManipulator $manipulator) : string
    {
        $relation = $field->getRelation();
        $relationType = $relation->getType();
        $inversedBy = $relation->getInversedBy();
        $owningClass = self::ENTITY_NAMESPACE . $field->getService()->getName();
        $inverseClass = self::ENTITY_NAMESPACE . $relation->getTargetEntity();

        $entityRelation = new EntityRelation($relationType, $owningClass, $inverseClass);
        $entityRelation->setOwningProperty($field->getName());
        $entityRelation->setIsNullable($field->getIsNullable());
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
