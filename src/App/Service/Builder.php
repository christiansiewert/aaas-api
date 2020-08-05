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

use App\Entity\Filter;
use App\Entity\Project;
use App\Entity\Field;
use App\Entity\Repository;
use App\Entity\Service;
use Exception;
use Symfony\Bundle\MakerBundle\Doctrine\EntityRelation;
use Symfony\Bundle\MakerBundle\Util\ClassNameValue;
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
     * Builds the sourcecode of a repository service
     *
     * @param Service $service
     * @throws Exception
     */
    public function buildService(Service $service)
    {
        /**
         * Generate entity and repository class
         */
        $this->classGenerator->generateRepositoryClass($service);
        $entityTargetPath = $this->classGenerator->generateEntityClass($service);
        $sourceCode = $this->classGenerator->generator->getFileContentsForPendingOperation($entityTargetPath);

        /**
         * Build annotations for api filters
         */
        foreach ($service->getFilters() as $filter) {
            $sourceCode = $this->buildFilter($filter, $sourceCode);
        }

        /**
         * Build entity fields, getters, setters, options and constraints
         */
        foreach ($service->getFields() as $field) {
            $sourceCode = $this->buildfield($field, $sourceCode);
        }

        /**
         * Dump file to filesystem
         */
        $this->classGenerator->generator->dumpFile($entityTargetPath, $sourceCode);
        $this->classGenerator->generator->writeChanges();
    }

    /**
     * Adds an entity field to our manipulator and returns the generated source code.
     *
     * @param Field $field
     * @param string $sourceCode
     * @throws Exception
     * @return string
     */
    public function buildfield(Field $field, string $sourceCode) : string
    {
        $dataType = $field->getDataType();
        $manipulator = new ClassSourceManipulator($sourceCode);
        $annotations = [];

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

        /**
         * Build field options
         */
        if ($field->getFieldOptions()->count() > 0) {
            $options['options'] = [];
            foreach ($field->getFieldOptions() as $fieldOption) {
                $options['options'][$fieldOption->getName()] = $fieldOption->getValue();
            }
        }

        /**
         * Build field constraints
         */
        if ($field->getConstraints()->count() > 0) {
            foreach ($field->getConstraints() as $constraint) {
                $constraintOptions = [];
                foreach ($constraint->getConstraintOptions() as $constraintOption) {
                    $constraintOptions[$constraintOption->getName()] = $constraintOption->getValue();
                }
                $annotations[] = $this->classGenerator
                    ->buildAnnotationLine('@Assert\\'.$constraint->getName(), $constraintOptions);
            }
        }

        $manipulator->addEntityField($field->getName(), $options, $annotations);

        return $manipulator->getSourceCode();
    }

    /**
     * Adds a field relation to our manipulator and returns the generated source code.
     *
     * @param Field $field
     * @param ClassSourceManipulator $manipulator
     * @throws Exception
     * @return string
     */
    public function buildFieldRelation(Field $field, ClassSourceManipulator $manipulator) : string
    {
        $relation = $field->getRelation();
        $relationType = $relation->getType();
        $owningClass = self::ENTITY_NAMESPACE.$field->getService()->getName();
        $inverseClass = self::ENTITY_NAMESPACE.$relation->getService()->getName();

        $entityRelation = new EntityRelation($relationType, $owningClass, $inverseClass);
        $entityRelation->setOwningProperty($field->getName());
        $entityRelation->setIsNullable($field->getIsNullable());
        $entityRelation->setMapInverseRelation(false);

        // @todo https://github.com/christiansiewert/aaas-api/issues/10
        // $inversedBy = $relation->getInversedBy();
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

    /**
     * Builds a annotation for the entity class and adds it to our sourcecode.
     *
     * @param Filter $filter
     * @param string $sourceCode
     * @return string
     */
    public function buildFilter(Filter $filter, string $sourceCode) : string
    {
        $properties = array();
        $manipulator = new ClassSourceManipulator($sourceCode);
        $filterClass = Filter::VALID_TYPES[$filter->getType()];

        foreach ($filter->getProperties() as $property) {
            $value = $property->getValue();
            $name = $property->getField()->getName();
            if ($value === null) {
                array_push($properties, $name);
            } else {
                $properties[$name] = $property->getValue();
            }
        }

        $manipulator->addAnnotationToClass('ApiPlatform\Core\Annotation\ApiFilter', [
            'value' => new ClassNameValue('Filter\\' . $filterClass, $filterClass),
            'properties' => $properties
        ]);

        return $manipulator->getSourceCode();
    }
}
