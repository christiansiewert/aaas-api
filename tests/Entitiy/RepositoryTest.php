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

use App\Entity\Project;
use App\Entity\Repository;
use App\Entity\Service;
use PHPUnit\Framework\TestCase;

/**
 * @author Christian Siewert <christian@sieware.international>
 */
class RepositoryTest extends TestCase
{
    /**
     * @var Repository
     */
    private $object;

    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        $this->object = new Repository();
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

    public function testProjectGettable()
    {
        $this->assertNull($this->object->getProject());
    }

    public function testProjectSettable()
    {
        $project = new Project();
        $this->object->setProject($project);
        $this->assertEquals($project, $this->object->getProject());
    }

    public function testServicesGettable()
    {
        $this->assertCount(0, $this->object->getServices());
    }

    public function testServicesAddable()
    {
        $this->object->addService(new Service());
        $this->assertCount(1, $this->object->getServices());
    }

    public function testServicesRemovable()
    {
        $relation = new Service();
        $this->object->addService($relation);
        $this->object->removeService($relation);
        $this->assertCount(0, $this->object->getServices());
    }
}
