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

use App\DataFixtures\ProjectFixtures;
use App\Test\ApiTestCase;
use \stdClass;

/**
 * @author Christian Siewert <christian@sieware.international>
 *
 * @todo refactore and rethink how we test
 */
class ProjectTest extends ApiTestCase
{
    const REPOSITORY_DATA = [
        'name' => 'My repository',
        'description' => 'My repository description.'
    ];

    const SERVICE_DATA = [
        'name' => 'My service',
        'description' => 'My service description.'
    ];

    private $data = [
        'name' => ProjectFixtures::PROJECT_DATA['name'],
        'description' => ProjectFixtures::PROJECT_DATA['description'],
        'repositories' => [
            [
                'name' => self::REPOSITORY_DATA['name'],
                'description' => self::REPOSITORY_DATA['description'],
                'services' => [
                    [
                        'name' => self::SERVICE_DATA['name'],
                        'description' => self::SERVICE_DATA['description']
                    ]
                ]
            ]
        ]
    ];

    public function testCanBeCreated()
    {
        unset($this->data['repositories']);
        $response = $this->post('/aaas/projects', $this->data);
        $content = json_decode($response->getContent());

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertIsNumeric($content->id);
        $this->assertEquals(ProjectFixtures::PROJECT_DATA['name'], $content->name);
        $this->assertEquals(ProjectFixtures::PROJECT_DATA['description'], $content->description);
    }


    public function testCanBeCreatedWithRepositories()
    {
        unset($this->data['repositories'][0]['services']);
        $response = $this->post('/aaas/projects?groups[]=repository', $this->data);
        $content = json_decode($response->getContent());

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertIsNumeric($content->id);
        $this->assertEquals(ProjectFixtures::PROJECT_DATA['name'], $content->name);
        $this->assertEquals(ProjectFixtures::PROJECT_DATA['description'], $content->description);
        $this->assertEquals(self::REPOSITORY_DATA['name'], $content->repositories[0]->name);
        $this->assertEquals(self::REPOSITORY_DATA['description'], $content->repositories[0]->description);
    }

    public function testCanBeCreatedWithRepositoriesAndServices()
    {
        $response = $this->post('/aaas/projects?groups[]=repository&groups[]=service', $this->data);
        $content = json_decode($response->getContent());

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertIsNumeric($content->id);
        $this->assertEquals(ProjectFixtures::PROJECT_DATA['name'], $content->name);
        $this->assertEquals(ProjectFixtures::PROJECT_DATA['description'], $content->description);
        $this->assertEquals(self::REPOSITORY_DATA['name'], $content->repositories[0]->name);
        $this->assertEquals(self::REPOSITORY_DATA['description'], $content->repositories[0]->description);
        $this->assertEquals(self::SERVICE_DATA['name'], $content->repositories[0]->services[0]->name);
        $this->assertEquals(self::SERVICE_DATA['description'], $content->repositories[0]->services[0]->description);
    }

    /**
     * @depends testCollectionCanBeFetched
     * @param stdClass $project
     */
    public function testCanBeFetched(stdClass $project)
    {
        $response = $this->get(sprintf('/aaas/projects/%s', $project->id));
        $content = json_decode($response->getContent());

        $this->assertIsNumeric($content->id);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(ProjectFixtures::PROJECT_DATA['name'], $content->name);
        $this->assertEquals(ProjectFixtures::PROJECT_DATA['description'], $content->description);
    }

    /**
     * @depends testCollectionCanBeFetched
     * @param stdClass $project
     */
    public function testCanBeEdited(stdClass $project)
    {
        $response = $this->put(sprintf('/aaas/projects/%s', $project->id), ['name' => 'My updated project']);
        $content = json_decode($response->getContent());

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('My updated project', $content->name);
    }

    public function testCollectionCanBeFetched()
    {
        $response = $this->get('/aaas/projects');
        $content = json_decode($response->getContent());

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertNotEmpty($content[0]);

        return $content[0];
    }
}
