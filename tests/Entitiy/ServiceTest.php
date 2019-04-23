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

use App\Entity\Repository;
use App\Entity\Service;
use App\Entity\ServiceField;
use App\Tests\EntityTestCase;
use \InvalidArgumentException;

/**
 * @author Christian Siewert <christian@sieware.international>
 */
class ServiceTest extends EntityTestCase
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

    public function testTypeGettable()
    {
        $this->assertMemberEquals('type', $this->object);
    }

    public function testTypeSettable()
    {
        $this->object->setType(Service::TYPE_LIST);
        $this->assertMemberEquals('type', $this->object, Service::TYPE_LIST);
    }

    public function testInvalidTypeRaisesException()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->object->setType('nil');
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
