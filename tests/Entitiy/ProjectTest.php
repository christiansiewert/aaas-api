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
use App\Tests\EntityTestCase;

/**
 * @author Christian Siewert <christian@sieware.international>
 */
class ProjectTest extends EntityTestCase
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
