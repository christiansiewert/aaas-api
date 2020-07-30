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
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use InvalidArgumentException;

/**
 * A service represents a table in your database and holds
 * several field definitions.
 *
 * @ORM\Entity
 * @ApiResource(
 *     routePrefix="/repository",
 *     normalizationContext={
 *         "groups"={"service"},
 *         "enable_max_depth" = true
 *     },
 *     denormalizationContext={
 *         "groups"={"service"},
 *         "enable_max_depth" = true
 *     }
 * )
 * @ApiFilter(
 *     SearchFilter::class,
 *     properties={
 *         "name": "word_start",
 *         "description" : "word_start",
 *         "repository" : "exact"
 *     }
 * )
 * @ApiFilter(
 *     GroupFilter::class,
 *     arguments={
 *         "whitelist" : {
 *             "project",
 *             "repository"
 *         }
 *     }
 * )
 * @ORM\Table(name="App_Repository_Service")
 * @author Christian Siewert <christian@sieware.international>
 */
class Service
{
    /**
     * A service of type `list` represents a list.
     */
    const TYPE_LIST = 'list';

    /**
     * A service of type `tree` represents a nested set.
     */
    const TYPE_TREE = 'tree';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("service")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("service")
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups("service")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, options={"default" : "list"})
     * @Groups("service")
     * @Assert\NotBlank
     */
    private $type = self::TYPE_LIST;

    /**
     * @ORM\ManyToOne(targetEntity="Repository", inversedBy="services")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"service"})
     * @MaxDepth(1)
     * @Assert\NotBlank
     */
    private $repository;

    /**
     * @ORM\OneToMany(targetEntity="Field", mappedBy="service", orphanRemoval=true, cascade={"persist", "remove"})
     * @Groups({"service"})
     */
    private $fields;

    /**
     * @ORM\OneToMany(targetEntity=Relation::class, mappedBy="service", orphanRemoval=true)
     */
    private $relations;

    public function __construct()
    {
        $this->fields = new ArrayCollection();
        $this->relations = new ArrayCollection();
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        if (!in_array($type, array(self::TYPE_LIST, self::TYPE_TREE))) {
            throw new InvalidArgumentException("Invalid type");
        }

        $this->type = $type;

        return $this;
    }

    public function getRepository(): ?Repository
    {
        return $this->repository;
    }

    public function setRepository(?Repository $repository): self
    {
        $this->repository = $repository;

        return $this;
    }

    public function getFields(): Collection
    {
        return $this->fields;
    }

    public function addField(Field $field): self
    {
        if (!$this->fields->contains($field)) {
            $this->fields[] = $field;
            $field->setService($this);
        }

        return $this;
    }

    public function removeField(Field $field): self
    {
        if ($this->fields->contains($field)) {
            $this->fields->removeElement($field);
            // set the owning side to null (unless already changed)
            if ($field->getService() === $this) {
                $field->setService(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Relation[]
     */
    public function getRelations(): Collection
    {
        return $this->relations;
    }

    public function addRelation(Relation $relation): self
    {
        if (!$this->relations->contains($relation)) {
            $this->relations[] = $relation;
            $relation->setService($this);
        }

        return $this;
    }

    public function removeRelation(Relation $relation): self
    {
        if ($this->relations->contains($relation)) {
            $this->relations->removeElement($relation);
            // set the owning side to null (unless already changed)
            if ($relation->getService() === $this) {
                $relation->setService(null);
            }
        }

        return $this;
    }
}
