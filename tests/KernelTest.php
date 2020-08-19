<?php

/*
 * This file is part of API as a Service.
 *
 * Copyright (c) 2019 Christian Siewert <christian@sieware.international>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @author Christian Siewert <christian@sieware.international>
 */
class KernelTest extends WebTestCase
{
    /**
     * @var KernelBrowser
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
        $this->assertEquals(404, $this->client->getResponse()->getStatusCode());
    }
}
