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

use App\Entity\Customer;
use PHPUnit\Framework\TestCase;

/**
 * @author Christian Siewert <christian@sieware.international>
 */
class CustomerTest extends TestCase
{
    /**
     * @var Customer
     */
    private $object;

    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        $this->object = new Customer();
    }

    public function testIdGettable()
    {
        $this->assertNull($this->object->getId());
    }
    public function testEmailGettable()
    {
        $this->assertNull($this->object->getEmail());
    }

    public function testEmailSettable()
    {
        $this->object->setEmail('e@mail.tld');
        $this->assertEquals('e@mail.tld', $this->object->getEmail());
    }

    public function testPasswordGettable()
    {
        $this->assertEquals('', $this->object->getPassword());
    }

    public function testPasswordSettable()
    {
        $this->object->setPassword('password');
        $this->assertEquals('password', $this->object->getPassword());
    }
}
