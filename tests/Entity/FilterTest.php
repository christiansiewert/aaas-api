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

use App\Entity\Filter;
use App\Entity\FilterProperty;
use PHPUnit\Framework\TestCase;
use InvalidArgumentException;

/**
 * @author Christian Siewert <christian@sieware.international>
 */
class FilterTest extends TestCase
{
    /**
     * @var Filter
     */
    private $object;

    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        $this->object = new Filter();
    }

    public function testIdGettable()
    {
        $this->assertNull($this->object->getId());
    }

    public function testTypeGettable()
    {
        $this->assertNull($this->object->getType());
    }

    public function testTypeSettable()
    {
        $this->object->setType('string');
        $this->assertEquals('string', $this->object->getType());
    }

    public function testInvalidTypeRaisesException()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->object->setType('NIL');
    }

    public function testPropertiesGettable()
    {
        $this->assertCount(0, $this->object->getProperties());
    }

    public function testPropertiesAddable()
    {
        $this->object->addProperty(new FilterProperty());
        $this->assertCount(1, $this->object->getProperties());
    }

    public function testPropertiesRemovable()
    {
        $filterProperty = new FilterProperty();
        $this->object->addProperty($filterProperty);
        $this->object->removeProperty($filterProperty);
        $this->assertCount(0, $this->object->getProperties());
    }
}
