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

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @author Christian Siewert <christian@sieware.international>
 */
class KernelTest extends WebTestCase
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        $this->client = static::createClient();
    }

    public function testApplicationExecutable()
    {
        $this->client->request('GET', '/');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
}
