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

use App\Entity\ConstraintOption;
use App\Entity\Field;
use App\Entity\Constraint;
use PHPUnit\Framework\TestCase;
use InvalidArgumentException;

/**
 * @author Christian Siewert <christian@sieware.international>
 */
class ConstraintTest extends TestCase
{
    /**
     * @var Constraint
     */
    private $object;

    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        $this->object = new Constraint();
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
        $this->object->setName('Null');
        $this->assertEquals('Null', $this->object->getName());
    }

    public function testInvalidNameRaisesException()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->object->setName('NIL');
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

    public function testConstraintOptionsGettable()
    {
        $this->assertCount(0, $this->object->getConstraintOptions());
    }

    public function testConstraintOptionsAddable()
    {
        $this->object->addConstraintOption(new ConstraintOption());
        $this->assertCount(1, $this->object->getConstraintOptions());
    }

    public function testConstraintOptionsRemovable()
    {
        $constraintOption = new ConstraintOption();
        $this->object->addConstraintOption($constraintOption);
        $this->object->removeConstraintOption($constraintOption);
        $this->assertCount(0, $this->object->getConstraintOptions());
    }
}
