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
     * Send a KernelBrowser HTTP-GET-Request
     *
     * @param string $uri
     * @param bool $auth
     * @return Response
     */
    protected function get(string $uri, bool $auth = true)
    {
        return $this->request('GET', $uri, [], $auth);
    }

    /**
     * Send a KernelBrowser HTTP-POST-Request
     *
     * @param string $uri
     * @param array $data
     * @param bool $auth
     * @return Response
     */
    protected function post(string $uri, array $data = [], bool $auth = true)
    {
        return $this->request('POST', $uri, $data, $auth);
    }

    /**
     * Send a KernelBrowser HTTP-PUT-Request
     *
     * @param string $uri
     * @param array $data
     * @param bool $auth
     * @return Response
     */
    protected function put(string $uri, array $data = [], bool $auth = true)
    {
        return $this->request('PUT', $uri, $data, $auth);
    }

    /**
     * Send a KernelBrowser HTTP-Request
     *
     * @param string $method
     * @param string $uri
     * @param array $data
     * @param bool $auth
     * @return Response
     */
    public function request(string $method, string $uri, array $data = [], bool $auth = true) : Response
    {
        $client = $auth === true ? $this->createAuthenticatedClient() : static::createClient();

        $client->request(
            $method,
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
}
