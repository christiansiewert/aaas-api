<?php

/*
 * This file is part of API as a Service.
 *
 * Copyright (c) 2019 Christian Siewert <christian@sieware.international>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Action;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @author Christian Siewert <christian@sieware.international>
 *
 * @todo refactore
 */
class SystemMigrator extends AbstractController
{
    /**
     * @Route(
     *     name="system_cache_clearer",
     *     methods={"GET"},
     *     path="/aaas/system/clear-cache"
     * )
     * @param KernelInterface $kernel
     * @return Response
     * @throws \Exception
     */
    public function clearCache(KernelInterface $kernel)
    {
        $application = new Application($kernel);
        $application->setAutoExit(false);
        $input = new ArrayInput(['command' => 'cache:clear']);

        $output = new NullOutput();
        $application->run($input, $output);

        return new JsonResponse(['status' => 'ok']);
    }

    /**
     * @Route(
     *     name="system_migrator",
     *     methods={"GET"},
     *     path="/aaas/system/migrate"
     * )
     * @param KernelInterface $kernel
     * @return Response
     * @throws \Exception
     */
    public function diffDatabase(KernelInterface $kernel)
    {
        $application = new Application($kernel);
        $application->setAutoExit(false);
        $input = new ArrayInput(['command' => 'doctrine:migrations:diff']);

        $output = new NullOutput();
        $application->run($input, $output);

        return $this->forward('App\Action\SystemMigrator::migrateDatabase');
    }

    /**
     * @param KernelInterface $kernel
     * @return JsonResponse
     * @throws \Exception
     */
    public function migrateDatabase(KernelInterface $kernel)
    {
        $application = new Application($kernel);
        $application->setAutoExit(false);
        $input = new ArrayInput(['command' => 'doctrine:migrations:migrate', '--no-interaction']);

        $output = new NullOutput();
        $application->run($input, $output);

        return new JsonResponse(['status' => 'ok']);
    }
}
