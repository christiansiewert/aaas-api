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

use App\Entity\Filter;
use App\Entity\Relation;
use App\Entity\Repository;
use App\Entity\Service;
use App\Entity\Field;
use PHPUnit\Framework\TestCase;
use InvalidArgumentException;

/**
 * @author Christian Siewert <christian@sieware.international>
 */
class ServiceTest extends TestCase
{
    /**
     * @var Service
     */
    private $object;

    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        $this->object = new Service();
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

    public function testTypeGettable()
    {
        $this->assertEquals(Service::TYPE_LIST, $this->object->getType());
    }

    public function testTypeSettable()
    {
        $this->object->setType(Service::TYPE_LIST);
        $this->assertEquals(Service::TYPE_LIST, $this->object->getType());
    }

    public function testInvalidTypeRaisesException()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->object->setType('NIL');
    }

    public function testRepositoryGettable()
    {
        $this->assertNull($this->object->getRepository());
    }

    public function testRepositorySettable()
    {
        $relation = new Repository();
        $this->object->setRepository(new Repository());
        $this->assertEquals($relation, $this->object->getRepository());
    }

    public function testFieldsGettable()
    {
        $this->assertCount(0, $this->object->getFields());
    }

    public function testFieldsAddable()
    {
        $this->object->addField(new Field());
        $this->assertCount(1, $this->object->getFields());
    }

    public function testFieldsRemovable()
    {
        $relation = new Field();
        $this->object->addField($relation);
        $this->object->removeField($relation);
        $this->assertCount(0, $this->object->getFields());
    }

    public function testRelationsGettable()
    {
        $this->assertCount(0, $this->object->getRelations());
    }

    public function testRelationsAddable()
    {
        $this->object->addRelation(new Relation());
        $this->assertCount(1, $this->object->getRelations());
    }

    public function testRelationsRemovable()
    {
        $relation = new Relation();
        $this->object->addRelation($relation);
        $this->object->removeRelation($relation);
        $this->assertCount(0, $this->object->getRelations());
    }

    public function testFiltersGettable()
    {
        $this->assertCount(0, $this->object->getFilters());
    }

    public function testFiltersAddable()
    {
        $this->object->addFilter(new Filter());
        $this->assertCount(1, $this->object->getFilters());
    }

    public function testFiltersRemovable()
    {
        $filter = new Filter();
        $this->object->addFilter($filter);
        $this->object->removeFilter($filter);
        $this->assertCount(0, $this->object->getFilters());
    }
}
