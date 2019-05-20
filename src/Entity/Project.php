<?php

/*
 * This file is part of API as a Service.
 *
 * Copyright (c) 2019 Christian Siewert <christian@sieware.international>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * A Project holds repositories.
 *
 * @ApiResource(
 *     itemOperations={
 *         "get"={"method"="GET"},
 *         "put"={"method"="PUT"},
 *         "delete"={"method"="DELETE"},
 *         "builder"={"route_name"="project_builder"}
 *     }
 * )
 * @ApiFilter(
 *     SearchFilter::class,
 *     properties={
 *         "name": "word_start",
 *         "description" : "word_start"
 *     }
 * )
 * @ORM\Entity()
 * @ORM\Table(name="App_Project")
 * @author Christian Siewert <christian@sieware.international>
 */
class Project
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProjectRepository", mappedBy="project", orphanRemoval=true)
     */
    private $repositories;

    public function __construct()
    {
        $this->repositories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|ProjectRepository[]
     */
    public function getRepositories(): Collection
    {
        return $this->repositories;
    }

    public function addRepository(ProjectRepository $repository): self
    {
        if (!$this->repositories->contains($repository)) {
            $this->repositories[] = $repository;
            $repository->setProject($this);
        }

        return $this;
    }

    public function removeRepository(ProjectRepository $repository): self
    {
        if ($this->repositories->contains($repository)) {
            $this->repositories->removeElement($repository);
            // set the owning side to null (unless already changed)
            if ($repository->getProject() === $this) {
                $repository->setProject(null);
            }
        }

        return $this;
    }
}
