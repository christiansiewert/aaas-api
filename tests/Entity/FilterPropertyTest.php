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

use App\Entity\Field;
use App\Entity\Filter;
use App\Entity\FilterProperty;
use PHPUnit\Framework\TestCase;
use InvalidArgumentException;

/**
 * @author Christian Siewert <christian@sieware.international>
 */
class FilterPropertyTest extends TestCase
{
    /**
     * @var FilterProperty
     */
    private $object;

    /**
     * @inheritDoc
     */
    protected function setUp() : void
    {
        $this->object = new FilterProperty();
    }

    public function testIdGettable()
    {
        $this->assertNull($this->object->getId());
    }

    public function testValueGettable()
    {
        $this->assertNull($this->object->getValue());
    }

    public function testValueSettable()
    {
        $this->object->setValue('value');
        $this->assertEquals('value', $this->object->getValue());
    }

    public function testFieldGettable()
    {
        $this->assertNull($this->object->getfield());
    }

    public function testFieldSettable()
    {
        $field = new Field();
        $this->object->setfield($field);
        $this->assertEquals($field, $this->object->getfield());
    }

    public function testFilterGettable()
    {
        $this->assertNull($this->object->getFilter());
    }

    public function testFilterSettable()
    {
        $filter = new Filter();
        $this->object->setFilter($filter);
        $this->assertEquals($filter, $this->object->getFilter());
    }
}
