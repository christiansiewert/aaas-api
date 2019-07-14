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
use InvalidArgumentException;

/**
 * A service represents a table in your database and holds
 * several field definitions.
 *
 * @ApiResource(routePrefix="/aaas")
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
 *             "service",
 *             "field"
 *         }
 *     }
 * )
 * @ORM\Entity()
 * @ORM\Table(name="App_Repository_Service")
 * @author Christian Siewert <christian@sieware.international>
 */
class RepositoryService
{
    const TYPE_LIST = 'list';
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
     * @ORM\ManyToOne(targetEntity="App\Entity\ProjectRepository", inversedBy="services")
     * @ORM\JoinColumn(nullable=false)
     */
    private $repository;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ServiceField", mappedBy="service", orphanRemoval=true, cascade={"persist", "remove"})
     * @Groups({"service", "field"})
     */
    private $fields;

    public function __construct()
    {
        $this->fields = new ArrayCollection();
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

    public function getRepository(): ?ProjectRepository
    {
        return $this->repository;
    }

    public function setRepository(?ProjectRepository $repository): self
    {
        $this->repository = $repository;

        return $this;
    }

    public function getFields(): Collection
    {
        return $this->fields;
    }

    public function addField(ServiceField $serviceField): self
    {
        if (!$this->fields->contains($serviceField)) {
            $this->fields[] = $serviceField;
            $serviceField->setService($this);
        }

        return $this;
    }

    public function removeField(ServiceField $serviceField): self
    {
        if ($this->fields->contains($serviceField)) {
            $this->fields->removeElement($serviceField);
            // set the owning side to null (unless already changed)
            if ($serviceField->getService() === $this) {
                $serviceField->setService(null);
            }
        }

        return $this;
    }
}
