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
use App\Tests\EntityTestCase;

/**
 * @author Christian Siewert <christian@sieware.international>
 */
class ServiceFieldTest extends EntityTestCase
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
        $this->assertMemberEquals('id', $this->object);
    }

    public function testNameGettable()
    {
        $this->assertMemberEquals('name', $this->object);
    }

    public function testNameSettable()
    {
        $this->object->setName('name');
        $this->assertMemberEquals('name', $this->object, 'name');
    }

    public function testDescriptionGettable()
    {
        $this->assertMemberEquals('description', $this->object);
    }

    public function testDescriptionSettable()
    {
        $this->object->setDescription('description');
        $this->assertMemberEquals('description', $this->object, 'description');
    }

    public function testDataTypeGettable()
    {
        $this->assertMemberEquals('dataType', $this->object);
    }

    public function testDataTypeSettable()
    {
        $this->object->setDataType('string');
        $this->assertMemberEquals('dataType', $this->object, 'string');
    }

    public function testLengthGettable()
    {
        $this->assertMemberEquals('length', $this->object, 255);
    }

    public function testLengthSettable()
    {
        $this->object->setLength(512);
        $this->assertMemberEquals('length', $this->object, 512);
    }

    public function testIsUniqueGettable()
    {
        $this->assertMemberEquals('isUnique', $this->object, false);
    }

    public function testIsUniqueSettable()
    {
        $this->object->setIsUnique(true);
        $this->assertMemberEquals('isUnique', $this->object, true);
    }

    public function testIsNullableGettable()
    {
        $this->assertMemberEquals('isNullable', $this->object, false);
    }

    public function testIsNullableSettable()
    {
        $this->object->setIsNullable(true);
        $this->assertMemberEquals('isNullable', $this->object, true);
    }

    public function testDataTypePrecisionGettable()
    {
        $this->assertMemberEquals('dataTypePrecision', $this->object);
    }

    public function testDataTypePrecisionSettable()
    {
        $this->object->setDataTypePrecision(1);
        $this->assertMemberEquals('dataTypePrecision', $this->object, 1);
    }

    public function testDataTypeScaleGettable()
    {
        $this->assertMemberEquals('dataTypeScale', $this->object);
    }

    public function testDataTypeScaleSettable()
    {
        $this->object->setDataTypeScale(1);
        $this->assertMemberEquals('dataTypeScale', $this->object, 1);
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
