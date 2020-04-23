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
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Serializer\Filter\GroupFilter;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\MaxDepth;

/**
 * A Repository holds services.
 *
 * @ORM\Entity
 * @ApiResource(
 *     routePrefix="/project",
 *     normalizationContext={
 *         "groups"={"repository"},
 *         "enable_max_depth" = true
 *     },
 *     denormalizationContext={
 *         "groups"={"repository"},
 *         "enable_max_depth" = true
 *     }
 * )
 * @ApiFilter(
 *     SearchFilter::class,
 *     properties={
 *         "name": "word_start",
 *         "description" : "word_start",
 *         "project" : "exact"
 *     }
 * )
 * @ApiFilter(
 *     GroupFilter::class,
 *     arguments={
 *         "whitelist" : {
 *             "service",
 *             "project"
 *         }
 *     }
 * )
 * @ORM\Table(name="App_Project_Repository")
 * @author Christian Siewert <christian@sieware.international>
 */
class Repository
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("repository")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("repository")
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups("repository")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="Project", inversedBy="repositories", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"repository"})
     * @MaxDepth(1)
     * @Assert\NotBlank
     */
    private $project;

    /**
     * @ORM\OneToMany(targetEntity="Service", mappedBy="repository", orphanRemoval=true, cascade={"persist", "remove"})
     * @Groups({"repository", "service"})
     * @Assert\Valid
     */
    private $services;

    public function __construct()
    {
        $this->services = new ArrayCollection();
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

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): self
    {
        $this->project = $project;

        return $this;
    }

    public function getServices(): Collection
    {
        return $this->services;
    }

    public function addService(Service $service): self
    {
        if (!$this->services->contains($service)) {
            $this->services[] = $service;
            $service->setRepository($this);
        }

        return $this;
    }

    public function removeService(Service $service): self
    {
        if ($this->services->contains($service)) {
            $this->services->removeElement($service);
            // set the owning side to null (unless already changed)
            if ($service->getRepository() === $this) {
                $service->setRepository(null);
            }
        }

        return $this;
    }
}
