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
use PHPUnit\Framework\TestCase;

/**
 * @author Christian Siewert <christian@sieware.international>
 */
class ServiceTest extends TestCase
{
    /**
     * @var Service
     */
    private $service;

    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        $this->service = new Service();
    }

    public function testIdGettable()
    {
        $this->assertNull($this->service->getId());
    }

    public function testNameGettable()
    {
        $this->assertNull($this->service->getName());
    }

    public function testNameSettable()
    {
        $this->service->setName('name');
        $this->assertEquals('name', $this->service->getName());
    }

    public function testDescriptionGettable()
    {
        $this->assertNull($this->service->getDescription());
    }

    public function testDescriptionSettable()
    {
        $this->service->setDescription('description');
        $this->assertEquals('description', $this->service->getDescription());
    }

    public function testTypeGettable()
    {
        $this->assertNull($this->service->getType());
    }

    public function testTypeSettable()
    {
        $this->service->setType(Service::TYPE_LIST);
        $this->assertEquals(Service::TYPE_LIST, $this->service->getType());
    }

    public function testInvalidTypeRaisesException()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->service->setType('nil');
    }

    public function testRepositoryGettable()
    {
        $this->assertNull($this->service->getRepository());
    }

    public function testRepositorySettable()
    {
        $repository = new Repository();
        $this->service->setRepository($repository);
        $this->assertEquals($repository, $this->service->getRepository());
    }

    public function testServiceFieldsGettable()
    {
        $this->assertCount(0, $this->service->getServiceFields());
    }

    public function testServiceFieldsAddable()
    {
        $serviceField = new ServiceField();
        $this->service->addServiceField($serviceField);
        $this->assertCount(1, $this->service->getServiceFields());
    }

    public function testServiceFieldsRemovable()
    {
        $serviceField = new ServiceField();
        $this->service->addServiceField($serviceField);
        $this->service->removeServiceField($serviceField);
        $this->assertCount(0, $this->service->getServiceFields());
    }
}
