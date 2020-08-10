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
use App\Entity\ConstraintOption;
use PHPUnit\Framework\TestCase;
use InvalidArgumentException;

/**
 * @author Christian Siewert <christian@sieware.international>
 */
class ConstraintOptionTest extends TestCase
{
    /**
     * @var ConstraintOption
     */
    private $object;

    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        $this->object = new ConstraintOption();
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
        $this->object->setName('message');
        $this->assertEquals('message', $this->object->getName());
    }

    public function testInvalidNameRaisesException()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->object->setName('NIL');
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

    public function testConstraintGettable()
    {
        $this->assertNull($this->object->getConstraint());
    }

    public function testConstraintSettable()
    {
        $constraint = new Constraint();
        $this->object->setConstraint($constraint);
        $this->assertEquals($constraint, $this->object->getConstraint());
    }
}
