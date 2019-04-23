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

use App\Entity\FieldOption;
use App\Entity\ServiceField;
use App\Tests\EntityTestCase;

/**
 * @author Christian Siewert <christian@sieware.international>
 */
class FieldOptionTest extends EntityTestCase
{
    /**
     * @var FieldOption
     */
    private $object;

    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        $this->object = new FieldOption();
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
