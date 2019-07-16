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

use App\Entity\Field;
use App\Entity\Constraint;
use PHPUnit\Framework\TestCase;

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
        $this->object->setName('name');
        $this->assertEquals('name', $this->object->getName());
    }

    public function testServiceFieldGettable()
    {
        $this->assertNull($this->object->getServiceField());
    }

    public function testServiceFieldSettable()
    {
        $relation = new Field();
        $this->object->setServiceField($relation);
        $this->assertEquals($relation, $this->object->getServiceField());
    }
}
