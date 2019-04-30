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

use App\Entity\AssertOption;
use App\Entity\FieldAssert;
use App\Entity\ServiceField;
use PHPUnit\Framework\TestCase;

/**
 * @author Christian Siewert <christian@sieware.international>
 */
class FieldAssertTest extends TestCase
{
    /**
     * @var FieldAssert
     */
    private $object;

    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        $this->object = new FieldAssert();
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

    public function testOptionsGettable()
    {
        $this->assertCount(0, $this->object->getOptions());
    }

    public function testOptionsAddable()
    {
        $this->object->addOption(new AssertOption());
        $this->assertCount(1, $this->object->getOptions());
    }

    public function testOptionsRemovable()
    {
        $relation = new AssertOption();
        $this->object->addOption($relation);
        $this->object->removeOption($relation);
        $this->assertCount(0, $this->object->getOptions());
    }

    public function testServiceFieldGettable()
    {
        $this->assertNull($this->object->getServiceField());
    }

    public function testServiceFieldSettable()
    {
        $relation = new ServiceField();
        $this->object->setServiceField($relation);
        $this->assertEquals($relation, $this->object->getServiceField());
    }
}
