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

use App\Entity\Project;
use App\Entity\Repository;
use PHPUnit\Framework\TestCase;

/**
 * @author Christian Siewert <christian@sieware.international>
 */
class ProjectTest extends TestCase
{
    /**
     * @var Project
     */
    private $object;

    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        $this->object = new Project();
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

    public function testRepositoriesGettable()
    {
        $this->assertCount(0, $this->object->getRepositories());
    }

    public function testRepositoriesAddable()
    {
        $this->object->addRepository(new Repository());
        $this->assertCount(1, $this->object->getRepositories());
    }

    public function testRepositoriesRemovable()
    {
        $relation = new Repository();
        $this->object->addRepository($relation);
        $this->object->removeRepository($relation);
        $this->assertCount(0, $this->object->getRepositories());
    }
}
