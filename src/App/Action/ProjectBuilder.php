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
use App\Service\Builder;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Generator actions for project resources
 *
 * @author Christian Siewert <christian@sieware.international>
 */
class ProjectBuilder
{
    /**
     * @var Builder
     */
    private $builder;

    /**
     * @param Builder $builder
     */
    public function __construct(Builder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * @Route(
     *     name="project_builder",
     *     methods={"GET"},
     *     path="/aaas/projects/{id}/build",
     *     defaults={
     *         "_api_resource_class"=Project::class,
     *         "_api_item_operation_name"="builder"
     *     }
     * )
     * @param Project $data
     * @return Project
     */
    public function __invoke(Project $data) : Project
    {
        $this->builder->buildProject($data);

        return $data;
    }
}
