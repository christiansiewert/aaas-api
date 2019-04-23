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

use App\Entity\AssertOption;
use App\Entity\FieldAssert;
use App\Entity\ServiceField;
use App\Tests\EntityTestCase;

/**
 * @author Christian Siewert <christian@sieware.international>
 */
class FieldAssertTest extends EntityTestCase
{
    /**
     * @var FieldAssert
     */
    private $object;

    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        $this->object = new FieldAssert();
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

    public function testOptionsGettable()
    {
        $this->assertCount(0, $this->object->getOptions());
    }

    public function testOptionsAddable()
    {
        $this->object->addOption(new AssertOption());
        $this->assertCount(1, $this->object->getOptions());
    }

    public function testOptionsRemovable()
    {
        $relation = new AssertOption();
        $this->object->addOption($relation);
        $this->object->removeOption($relation);
        $this->assertCount(0, $this->object->getOptions());
    }

    public function testServiceFieldGettable()
    {
        $this->assertMemberEquals('serviceField', $this->object);
    }

    public function testServiceFieldSettable()
    {
        $relation = new ServiceField();
        $this->object->setServiceField($relation);
        $this->assertEquals($relation, $this->object->getServiceField());
    }
}
