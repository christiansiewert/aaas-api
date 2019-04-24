<?php

/*
 * This file is part of the API as a Service Project.
 *
 * Copyright (c) 2019 Christian Siewert <christian@sieware.international>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tests\Entitiy;

use App\Entity\FieldAssert;
use App\Entity\FieldOption;
use App\Entity\ServiceField;
use PHPUnit\Framework\TestCase;

/**
 * @author Christian Siewert <christian@sieware.international>
 */
class ServiceFieldTest extends TestCase
{
    /**
     * @var ServiceField
     */
    private $object;

    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        $this->object = new ServiceField();
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
        $this->assertNull($this->object->getDataType());
    }

    public function testDataTypeSettable()
    {
        $this->object->setDataType('string');
        $this->assertEquals('string', $this->object->getDataType());
    }

    public function testLengthGettable()
    {
        $this->assertEquals(255, $this->object->getLength());
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

    public function testOptionsGettable()
    {
        $this->assertCount(0, $this->object->getOptions());
    }

    public function testOptionsAddable()
    {
        $this->object->addOption(new FieldOption());
        $this->assertCount(1, $this->object->getOptions());
    }

    public function testOptionsRemovable()
    {
        $relation = new FieldOption();
        $this->object->addOption($relation);
        $this->object->removeOption($relation);
        $this->assertCount(0, $this->object->getOptions());
    }

    public function testAssertionsGettable()
    {
        $this->assertCount(0, $this->object->getAssertions());
    }

    public function testAssertionsAddable()
    {
        $this->object->addAssertion(new FieldAssert());
        $this->assertCount(1, $this->object->getAssertions());
    }

    public function testAssertionsRemovable()
    {
        $relation = new FieldAssert();
        $this->object->addAssertion($relation);
        $this->object->removeAssertion($relation);
        $this->assertCount(0, $this->object->getAssertions());
    }
}
