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
use App\Entity\RelationCascade;
use PHPUnit\Framework\TestCase;

/**
 * @author Christian Siewert <christian@sieware.international>
 */
class RelationCascadeTest extends TestCase
{
    /**
     * @var RelationCascade
     */
    private $object;

    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        $this->object = new RelationCascade();
    }

    public function testIdGettable()
    {
        $this->assertNull($this->object->getId());
    }

    public function testValueGettable()
    {
        $this->assertNull($this->object->getValue());
    }

    public function testValueSettable()
    {
        $this->object->setValue('persist');
        $this->assertEquals('persist', $this->object->getValue());
    }

    public function testInvalidValueRaisesException()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->object->setValue('NIL');
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
