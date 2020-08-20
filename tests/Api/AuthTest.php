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
 */
class AuthTest extends ApiTestCase
{
   const VALID_AUTH_DATA = [
       'email' => 'test.user@aaas.api',
       'password' => 'test'
   ];

   const INVALID_AUTH_DATA = [
       'email' => 'foo@bar.baz',
       'password' => 'quux'
   ];

    public function testValidCredentialsRetrievesJwtToken()
    {
        $response = $this->post('/auth/login_check', self::VALID_AUTH_DATA, false);
        $content = json_decode($response->getContent());

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertObjectHasAttribute('token', $content);
    }

    public function testInvalidCredentialsResultsIn401UnauthorizedError()
    {
        $response = $this->post('/auth/login_check', self::INVALID_AUTH_DATA, false);

        $this->assertEquals(401, $response->getStatusCode());
    }
}
