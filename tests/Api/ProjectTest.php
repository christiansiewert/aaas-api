<?php

/*
 * This file is part of API as a Service.
 *
 * Copyright (c) 2019 Christian Siewert <christian@sieware.international>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tests\Api;

use App\Test\ApiTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @author Christian Siewert <christian@sieware.international>
 */
class ProjectTest extends ApiTestCase
{
    const URI = '/aaas/projects';

    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        $this->client = static::createClient();
    }

    public function testApiProjectAddable()
    {
        $this->request('POST', self::URI, [
            'name' => 'test',
            'description' => 'desc'
        ]);

        $response = $this->client->getResponse();
        $content = json_decode($response->getContent());

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertIsNumeric($content->id);
        $this->assertEquals('test', $content->name);
        $this->assertEquals('desc', $content->description);
    }
}
