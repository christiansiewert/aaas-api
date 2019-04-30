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

use App\Entity\ProjectRepository;
use App\Entity\RepositoryService;
use App\Entity\ServiceField;
use PHPUnit\Framework\TestCase;
use InvalidArgumentException;

/**
 * @author Christian Siewert <christian@sieware.international>
 */
class RepositoryServiceTest extends TestCase
{
    /**
     * @var RepositoryService
     */
    private $object;

    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        $this->object = new RepositoryService();
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
        $this->assertNull($this->object->getType());
    }

    public function testTypeSettable()
    {
        $this->object->setType(RepositoryService::TYPE_LIST);
        $this->assertEquals(RepositoryService::TYPE_LIST, $this->object->getType());
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
        $relation = new ProjectRepository();
        $this->object->setRepository(new ProjectRepository());
        $this->assertEquals($relation, $this->object->getRepository());
    }

    public function testServiceFieldsGettable()
    {
        $this->assertCount(0, $this->object->getServiceFields());
    }

    public function testServiceFieldsAddable()
    {
        $this->object->addServiceField(new ServiceField());
        $this->assertCount(1, $this->object->getServiceFields());
    }

    public function testServiceFieldsRemovable()
    {
        $relation = new ServiceField();
        $this->object->addServiceField($relation);
        $this->object->removeServiceField($relation);
        $this->assertCount(0, $this->object->getServiceFields());
    }
}
