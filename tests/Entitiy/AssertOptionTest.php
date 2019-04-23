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
use App\Tests\EntityTestCase;

/**
 * @author Christian Siewert <christian@sieware.international>
 */
class AssertOptionTest extends EntityTestCase
{
    /**
     * @var AssertOption
     */
    private $object;

    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        $this->object = new AssertOption();
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

    public function testValueGettable()
    {
        $this->assertMemberEquals('value', $this->object);
    }

    public function testValueSettable()
    {
        $this->object->setValue('value');
        $this->assertMemberEquals('value', $this->object, 'value');
    }

    public function testFieldAssertGettable()
    {
        $this->assertMemberEquals('fieldAssert', $this->object);
    }

    public function testFieldAssertSettable()
    {
        $relation = new FieldAssert();
        $this->object->setFieldAssert($relation);
        $this->assertEquals($relation, $this->object->getFieldAssert());
    }
}
