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

use App\Repository\CustomerRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Christian Siewert <christian@sieware.international>
 */
class ApiTestCase extends WebTestCase
{
    /**
     * Create a client with a default Authorization header.
     *
     * @param string $username
     * @return KernelBrowser
     */
    protected function createAuthenticatedClient($username = 'test.user@aaas.api') : KernelBrowser
    {
        $client = static::createClient();

        $userRepository = self::$container->get(CustomerRepository::class);
        $testUser = $userRepository->findOneByEmail($username);
        $token = self::$container->get('lexik_jwt_authentication.jwt_manager')->create($testUser);

        $client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $token));

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

    protected function get(string $uri)
    {
        $client = $this->createAuthenticatedClient();

        $client->request(
            'GET',
            $uri,
            [],
            [],
            [
                'HTTP_ACCEPT' => 'application/json'
            ]
        );

        return $client->getResponse();
    }
}
