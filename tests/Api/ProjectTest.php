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

/**
 * @author Christian Siewert <christian@sieware.international>
 *
 * @todo refactore and rethink how we test
 */
class ProjectTest extends ApiTestCase
{
    const PROJECT_DATA = [
        'name' => 'My project',
        'description' => 'My project description.'
    ];

    const REPOSITORY_DATA = [
        'name' => 'My repository',
        'description' => 'My repository description.'
    ];

    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        $this->client = static::createClient();
    }

    public function testApiProjectAddable()
    {
        $this->request('POST', '/aaas/projects', [
            'name' => self::PROJECT_DATA['name'],
            'description' => self::PROJECT_DATA['description']
        ]);

        $response = $this->client->getResponse();
        $content = json_decode($response->getContent());

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertIsNumeric($content->id);
        $this->assertEquals(self::PROJECT_DATA['name'], $content->name);
        $this->assertEquals(self::PROJECT_DATA['description'], $content->description);
    }

    public function testApiProjectWithRepositoriesAddable()
    {
        $this->request('POST', '/aaas/projects?groups[]=repository', [
            'name' => self::PROJECT_DATA['name'],
            'description' => self::PROJECT_DATA['description'],
            'repositories' => [
                [
                    'name' => self::REPOSITORY_DATA['name'],
                    'description' => self::REPOSITORY_DATA['description']
                ]
            ]
        ]);

        $response = $this->client->getResponse();
        $content = json_decode($response->getContent());

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertIsNumeric($content->id);
        $this->assertEquals(self::PROJECT_DATA['name'], $content->name);
        $this->assertEquals(self::PROJECT_DATA['description'], $content->description);

        $this->assertEquals(self::REPOSITORY_DATA['name'], $content->repositories[0]->name);
        $this->assertEquals(self::REPOSITORY_DATA['description'], $content->repositories[0]->description);
    }
}
