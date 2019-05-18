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

use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Project;

/**
 * Generator actions for project resources
 *
 * @author Christian Siewert <christian@sieware.international>
 */
class ProjectGenerator
{
    /**
     * @var Generator
     */
    private $generator;

    /**
     * @param Generator $generator
     */
    public function __construct(Generator $generator)
    {
        $this->generator = $generator;
    }

    /**
     * @Route(
     *     name="project_generator",
     *     methods={"GET"},
     *     path="/projects/{id}/generate",
     *     defaults={
     *         "_api_resource_class"=Project::class,
     *         "_api_item_operation_name"="generator"
     *     }
     * )
     */
    public function __invoke($data)
    {
        die("foo");

        return $data;
    }
}
