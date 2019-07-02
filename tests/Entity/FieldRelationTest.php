<?php

/*
 * This file is part of API as a Service.
 *
 * Copyright (c) 2019 Christian Siewert <christian@sieware.international>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tests\Entity;

use App\Entity\FieldRelation;
use App\Entity\RelationCascade;
use App\Entity\RelationJoincolumn;
use App\Entity\ServiceField;
use PHPUnit\Framework\TestCase;
use InvalidArgumentException;

/**
 * @author Christian Siewert <christian@sieware.international>
 */
class FieldRelationTest extends TestCase
{
    /**
     * @var FieldRelation
     */
    private $object;

    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        $this->object = new FieldRelation();
    }

    public function testIdGettable()
    {
        $this->assertNull($this->object->getId());
    }

    public function testTypeGettable()
    {
        $this->assertEquals(FieldRelation::VALID_RELATION_TYPES[0], $this->object->getType());
    }

    public function testTypeSettable()
    {
        $this->object->setType(FieldRelation::VALID_RELATION_TYPES[0]);
        $this->assertEquals(FieldRelation::VALID_RELATION_TYPES[0], $this->object->getType());
    }

    public function testInvalidTypeRaisesException()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->object->setType('NIL');
    }

    public function testTargetEntityGettable()
    {
        $this->assertNull($this->object->getTargetEntity());
    }

    public function testTargetEntitySettable()
    {
        $this->object->setTargetEntity('target');
        $this->assertEquals('target', $this->object->getTargetEntity());
    }

    public function testMappedByGettable()
    {
        $this->assertNull($this->object->getMappedBy());
    }

    public function testMappedBySettable()
    {
        $this->object->setMappedBy('property');
        $this->assertEquals('property', $this->object->getMappedBy());
    }

    public function testInversedByGettable()
    {
        $this->assertNull($this->object->getInversedBy());
    }

    public function testInversedBySettable()
    {
        $this->object->setInversedBy('property');
        $this->assertEquals('property', $this->object->getInversedBy());
    }

    public function testOrphanRemovalGettable()
    {
        $this->assertFalse($this->object->getOrphanRemoval());
    }

    public function testOrphanRemovalSettable()
    {
        $this->object->setOrphanRemoval(true);
        $this->assertTrue($this->object->getOrphanRemoval());
    }

    public function testServiceFieldGettable()
    {
        $this->assertNull($this->object->getServiceField());
    }

    public function testServiceFieldSettable()
    {
        $serviceField = new ServiceField();
        $this->object->setServiceField($serviceField);
        $this->assertEquals($serviceField, $this->object->getServiceField());
    }

    public function testJoinColumnIsUniqueGettable()
    {
        $this->assertFalse($this->object->getJoinColumnIsUnique());
    }

    public function testJoinColumnIsUniqueSettable()
    {
        $this->object->setJoinColumnIsUnique(true);
        $this->assertTrue($this->object->getJoinColumnIsUnique());
    }

    public function testJoinColumnIsNullableGettable()
    {
        $this->assertTrue($this->object->getJoinColumnIsNullable());
    }

    public function testJoinColumnIsNullableSettable()
    {
        $this->object->setJoinColumnIsNullable(false);
        $this->assertFalse($this->object->getJoinColumnIsNullable());
    }

    public function testJoinColumnNameGettable()
    {
        $this->assertNull($this->object->getJoinColumnName());
    }

    public function testJoinColumnNameSettable()
    {
        $this->object->setJoinColumnName('name');
        $this->assertEquals('name', $this->object->getJoinColumnName());
    }

    public function testJoinColumnReferencedColumnNameGettable()
    {
        $this->assertEquals('id', $this->object->getJoinColumnReferencedColumnName());
    }

    public function testJoinColumnReferencedColumnNameSettable()
    {
        $this->object->setJoinColumnReferencedColumnName('name');
        $this->assertEquals('name', $this->object->getJoinColumnReferencedColumnName());
    }

    public function testCascadesGettable()
    {
        $this->assertCount(0, $this->object->getCascades());
    }

    public function testCascadesAddable()
    {
        $this->object->addCascade(new RelationCascade());
        $this->assertCount(1, $this->object->getCascades());
    }

    public function testCascadesRemovable()
    {
        $cascade = new RelationCascade();
        $this->object->addCascade($cascade);
        $this->object->removeCascade($cascade);
        $this->assertCount(0, $this->object->getCascades());
    }
}
