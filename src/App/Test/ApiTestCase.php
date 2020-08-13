<?php

/*
 * This file is part of API as a Service.
 *
 * Copyright (c) 2019 Christian Siewert <christian@sieware.international>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Test;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @author Christian Siewert <christian@sieware.international>
 */
class ApiTestCase extends WebTestCase
{
    /**
     * Accept and Content-Type HTTP header will be
     * set to application/json in our test suite.
     */
    const HTTP_HEADER = [
        'HTTP_ACCEPT' => 'application/json',
        'CONTENT_TYPE' => 'application/json'
    ];

    /**
     * @var KernelBrowser
     */
    protected $client;

    /**
     * @param string $method
     * @param string $uri
     * @param array $data
     */
    protected function request(string $method = 'POST', string $uri = '/', array $data = [])
    {
        $this->client->request($method, $uri, [], [], self::HTTP_HEADER, json_encode($data));
    }
}
