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
use PHPUnit\Framework\TestCase;

/**
 * @author Christian Siewert <christian@sieware.international>
 */
class AssertOptionTest extends TestCase
{
    /**
     * @var AssertOption
     */
    private $object;

    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        $this->object = new AssertOption();
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

    public function testValueGettable()
    {
        $this->assertNull($this->object->getValue());
    }

    public function testValueSettable()
    {
        $this->object->setValue('value');
        $this->assertEquals('value', $this->object->getValue());
    }

    public function testFieldAssertGettable()
    {
        $this->assertNull($this->object->getFieldAssert());
    }

    public function testFieldAssertSettable()
    {
        $relation = new FieldAssert();
        $this->object->setFieldAssert($relation);
        $this->assertEquals($relation, $this->object->getFieldAssert());
    }
}
