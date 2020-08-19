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
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Christian Siewert <christian@sieware.international>
 */
class ApiTestCase extends WebTestCase
{
    /**
     * @var KernelBrowser
     */
    private static $client = null;

    /**
     * Create a client with a default Authorization header.
     *
     * @param string $username
     * @param string $password
     * @return KernelBrowser
     */
    protected function createAuthenticatedClient($username = 'test.user@aaas.api', $password = 'test')
    {
        if (self::$client !== null) {
            return self::$client;
        }

        $client = static::createClient();
        $client->request(
            'POST',
            '/auth/login_check',
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_ACCEPT' => 'application/json'
            ],
            json_encode([
                'email' => $username,
                'password' => $password
            ])
        );

        $data = json_decode($client->getResponse()->getContent());
        $client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $data->token));

        return $client;
    }

    /**
     * @param string $uri
     * @param array $data
     * @return Response
     */
    protected function post(string $uri, array $data = [])
    {
        $client = $this->createAuthenticatedClient();

        $client->request(
            'POST',
            $uri,
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_ACCEPT' => 'application/json'
            ],
            json_encode($data)
        );

        return $client->getResponse();
    }
}
