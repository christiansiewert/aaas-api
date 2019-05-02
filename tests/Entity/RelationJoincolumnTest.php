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
use App\Entity\RelationJoincolumn;
use PHPUnit\Framework\TestCase;

/**
 * @author Christian Siewert <christian@sieware.international>
 */
class RelationJoincolumnTest extends TestCase
{
    /**
     * @var RelationJoincolumn
     */
    private $object;

    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        $this->object = new RelationJoincolumn();
    }

    public function testIdGettable()
    {
        $this->assertNull($this->object->getId());
    }

    public function testNameGettable()
    {
        $this->assertNull($this->object->getName());
    }

    public function testNameSettable()
    {
        $this->object->setName('name');
        $this->assertEquals('name', $this->object->getName());
    }

    public function testReferencedColumnNameGettable()
    {
        $this->assertEquals('id', $this->object->getReferencedColumnName());
    }

    public function testReferencedColumnNameSettable()
    {
        $this->object->setReferencedColumnName('name');
        $this->assertEquals('name', $this->object->getReferencedColumnName());
    }

    public function testIsUniqueGettable()
    {
        $this->assertFalse($this->object->getIsUnique());
    }

    public function testIsUniqueSettable()
    {
        $this->object->setIsUnique(true);
        $this->assertTrue($this->object->getIsUnique());
    }

    public function testIsNullableGettable()
    {
        $this->assertTrue($this->object->getIsNullable());
    }

    public function testIsNullableSettable()
    {
        $this->object->setIsNullable(false);
        $this->assertFalse($this->object->getIsNullable());
    }

    public function testFieldRelationGettable()
    {
        $this->assertNull($this->object->getFieldRelation());
    }

    public function testFieldRelationSettable()
    {
        $relation = new FieldRelation();
        $this->object->setFieldRelation($relation);
        $this->assertEquals($relation, $this->object->getFieldRelation());
    }
}
