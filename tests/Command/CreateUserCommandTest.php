<?php

/*
 * This file is part of API as a Service.
 *
 * Copyright (c) 2019 Christian Siewert <christian@sieware.international>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tests\Command;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * @author Christian Siewert <christian@sieware.international>
 */
class CreateUserCommandTest extends KernelTestCase
{
    const USER_DATA = [
        'email' => 'command.line.test.user@aaas.api',
        'password' => 'test'
    ];

    public function testUserCreatableFromCommandLine()
    {
        $kernel = static::createKernel();
        $application = new Application($kernel);

        $command = $application->find('acl:create-user');
        $commandTester = new CommandTester($command);
        $commandTester->execute(self::USER_DATA);

        $output = $commandTester->getDisplay();
        $this->assertStringContainsString(self::USER_DATA['email'], $output);
    }
}
