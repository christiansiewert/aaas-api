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

use App\Entity\Relation;
use App\Entity\Field;
use App\Entity\Service;
use PHPUnit\Framework\TestCase;
use InvalidArgumentException;
use Symfony\Bundle\MakerBundle\Doctrine\EntityRelation;

/**
 * @author Christian Siewert <christian@sieware.international>
 */
class RelationTest extends TestCase
{
    /**
     * @var Relation
     */
    private $object;

    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        $this->object = new Relation();
    }

    public function testIdGettable()
    {
        $this->assertNull($this->object->getId());
    }

    public function testTypeGettable()
    {
        $this->assertEquals(EntityRelation::MANY_TO_ONE, $this->object->getType());
    }

    public function testTypeSettable()
    {
        $this->object->setType(EntityRelation::MANY_TO_MANY);
        $this->assertEquals(EntityRelation::MANY_TO_MANY, $this->object->getType());
    }

    public function testInvalidTypeRaisesException()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->object->setType('NIL');
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

    public function testFieldGettable()
    {
        $this->assertNull($this->object->getfield());
    }

    public function testFieldSettable()
    {
        $field = new Field();
        $this->object->setfield($field);
        $this->assertEquals($field, $this->object->getfield());
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

    public function testServiceGettable()
    {
        $this->assertNull($this->object->getService());
    }

    public function testServiceSettable()
    {
        $service = new Service();
        $this->object->setService($service);
        $this->assertEquals($service, $this->object->getService());
    }
}
