<?php

/*
 * This file is part of the API as a Service Project.
 *
 * Copyright (c) 2019 Christian Siewert <christian@sieware.international>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tests;

use PHPUnit\Framework\TestCase;

/**
 * @author Christian Siewert <christian@sieware.international>
 */
class EntityTestCase extends TestCase
{
    /**
     * Calls a method of an object and asserts that
     * it is either null or equals expected
     *
     * @param string $member
     * @param $object
     * @param string|null $expected
     */
    public function assertMemberEquals(string $member, $object, string $expected = null)
    {
        $method = 'get' . ucfirst($member);

        $expected === null ?
            $this->assertNull($object->$method()) :
            $this->assertEquals($expected, $object->$method());
    }
}
