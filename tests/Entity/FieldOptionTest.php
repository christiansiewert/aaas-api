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

use App\Entity\FieldOption;
use App\Entity\Field;
use PHPUnit\Framework\TestCase;

/**
 * @author Christian Siewert <christian@sieware.international>
 */
class FieldOptionTest extends TestCase
{
    /**
     * @var FieldOption
     */
    private $object;

    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        $this->object = new FieldOption();
    }

    public function testIdGettable()
    {
        $this->assertNull($this->object->getId());
    }

    public function testfieldGettable()
    {
        $this->assertNull($this->object->getfield());
    }

    public function testfieldSettable()
    {
        $relation = new Field();
        $this->object->setfield($relation);
        $this->assertEquals($relation, $this->object->getfield());
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
}
