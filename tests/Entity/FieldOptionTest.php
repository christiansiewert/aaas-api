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

use App\Entity\FieldOption;
use App\Entity\ServiceField;
use PHPUnit\Framework\TestCase;

/**
 * @author Christian Siewert <christian@sieware.international>
 */
class FieldOptionTest extends TestCase
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
        $this->assertNull($this->object->getId());
    }

    public function testServiceFieldGettable()
    {
        $this->assertNull($this->object->getServiceField());
    }

    public function testServiceFieldSettable()
    {
        $relation = new ServiceField();
        $this->object->setServiceField($relation);
        $this->assertEquals($relation, $this->object->getServiceField());
    }
}
