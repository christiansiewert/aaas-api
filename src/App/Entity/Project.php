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
use ApiPlatform\Core\Serializer\Filter\GroupFilter;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * A Project holds repositories.
 *
 * @ORM\Entity
 * @ApiResource(
 *     itemOperations={
 *         "get",
 *         "put",
 *         "delete",
 *         "builder"={
 *             "route_name"="project_builder",
 *             "swagger_context"={
 *                 "summary"="Generates API from an existing project."
 *             }
 *         }
 *     }
 * )
 * @ApiFilter(
 *     SearchFilter::class,
 *     properties={
 *         "name": "word_start",
 *         "description" : "word_start"
 *     }
 * )
 * @ApiFilter(
 *     GroupFilter::class,
 *     arguments={
 *         "whitelist" : {
 *             "project",
 *             "repository",
 *             "service",
 *             "field",
 *             "option",
 *             "constraint",
 *             "relation"
 *         }
 *     }
 * )
 * @ORM\Table(name="App_Project")
 * @author Christian Siewert <christian@sieware.international>
 */
class Project
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("project")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("project")
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups("project")
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="Repository", mappedBy="project", orphanRemoval=true, cascade={"persist", "remove"})
     * @Groups({"project", "repository"})
     * @Assert\Valid
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

    public function getRepositories(): Collection
    {
        return $this->repositories;
    }

    public function addRepository(Repository $repository): self
    {
        if (!$this->repositories->contains($repository)) {
            $this->repositories[] = $repository;
            $repository->setProject($this);
        }

        return $this;
    }

    public function removeRepository(Repository $repository): self
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
