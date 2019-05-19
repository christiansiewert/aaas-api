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

use App\Entity\Project;
use App\Service\ProjectBuilder;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Generator actions for project resources
 *
 * @author Christian Siewert <christian@sieware.international>
 */
class ProjectGenerator
{
    /**
     * @var ProjectBuilder
     */
    private $builder;

    /**
     * @param ProjectBuilder $builder
     */
    public function __construct(ProjectBuilder $builder)
    {
        $this->builder = $builder;
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
     * @param Project $data
     * @return Project
     */
    public function __invoke($data)
    {
        $this->builder->build($data);

        return $data;
    }
}
