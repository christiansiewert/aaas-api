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

use App\Entity\Constraint;
use App\Entity\FieldOption;
use App\Entity\Field;
use PHPUnit\Framework\TestCase;
use InvalidArgumentException;

/**
 * @author Christian Siewert <christian@sieware.international>
 */
class FieldTest extends TestCase
{
    /**
     * @var Field
     */
    private $object;

    /**
     * @inheritDoc
     */
    protected function setUp() : void
    {
        $this->object = new Field();
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

    public function testDescriptionGettable()
    {
        $this->assertNull($this->object->getDescription());
    }

    public function testDescriptionSettable()
    {
        $this->object->setDescription('description');
        $this->assertEquals('description', $this->object->getDescription());
    }

    public function testDataTypeGettable()
    {
        $this->assertEquals('string', $this->object->getDataType());
    }

    public function testDataTypeSettable()
    {
        $this->object->setDataType('string');
        $this->assertEquals('string', $this->object->getDataType());
    }

    public function testLengthGettable()
    {
        $this->assertNull($this->object->getLength());
    }

    public function testLengthSettable()
    {
        $this->object->setLength(512);
        $this->assertEquals(512, $this->object->getLength());
    }

    public function testIsUniqueGettable()
    {
        $this->assertEquals(false, $this->object->getIsUnique());
    }

    public function testIsUniqueSettable()
    {
        $this->object->setIsUnique(true);
        $this->assertEquals(true, $this->object->getIsUnique());
    }

    public function testIsNullableGettable()
    {
        $this->assertEquals(false, $this->object->getIsNullable());
    }

    public function testIsNullableSettable()
    {
        $this->object->setIsNullable(true);
        $this->assertEquals(true, $this->object->getIsNullable());
    }

    public function testDataTypePrecisionGettable()
    {
        $this->assertNull($this->object->getDataTypePrecision());
    }

    public function testDataTypePrecisionSettable()
    {
        $this->object->setDataTypePrecision(1);
        $this->assertEquals(1, $this->object->getDataTypePrecision());
    }

    public function testDataTypeScaleGettable()
    {
        $this->assertNull($this->object->getDataTypeScale());
    }

    public function testDataTypeScaleSettable()
    {
        $this->object->setDataTypeScale(1);
        $this->assertEquals(1, $this->object->getDataTypeScale());
    }

    public function testFieldOptionsGettable()
    {
        $this->assertCount(0, $this->object->getFieldOptions());
    }

    public function testOptionsAddable()
    {
        $this->object->addFieldOption(new FieldOption());
        $this->assertCount(1, $this->object->getFieldOptions());
    }

    public function testOptionsRemovable()
    {
        $relation = new FieldOption();
        $this->object->addFieldOption($relation);
        $this->object->removeFieldOption($relation);
        $this->assertCount(0, $this->object->getFieldOptions());
    }

    public function testAssertionsGettable()
    {
        $this->assertCount(0, $this->object->getConstraints());
    }

    public function testAssertionsAddable()
    {
        $this->object->addConstraint(new Constraint());
        $this->assertCount(1, $this->object->getConstraints());
    }

    public function testAssertionsRemovable()
    {
        $relation = new Constraint();
        $this->object->addConstraint($relation);
        $this->object->removeConstraint($relation);
        $this->assertCount(0, $this->object->getConstraints());
    }

    public function testInvalidDataTypeRaisesException()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->object->setDataType('NIL');
    }
}
