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
use \InvalidArgumentException;

/**
 * A service represents a table in your database and holds
 * several field definitions.
 *
 * @ApiResource()
 * @ApiFilter(
 *     SearchFilter::class,
 *     properties={
 *         "name": "word_start",
 *         "description" : "word_start"
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
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ProjectRepository", inversedBy="services")
     * @ORM\JoinColumn(nullable=false)
     */
    private $repository;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ServiceField", mappedBy="service", orphanRemoval=true)
     */
    private $serviceFields;

    public function __construct()
    {
        $this->serviceFields = new ArrayCollection();
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

    /**
     * @return Collection|ServiceField[]
     */
    public function getServiceFields(): Collection
    {
        return $this->serviceFields;
    }

    public function addServiceField(ServiceField $serviceField): self
    {
        if (!$this->serviceFields->contains($serviceField)) {
            $this->serviceFields[] = $serviceField;
            $serviceField->setService($this);
        }

        return $this;
    }

    public function removeServiceField(ServiceField $serviceField): self
    {
        if ($this->serviceFields->contains($serviceField)) {
            $this->serviceFields->removeElement($serviceField);
            // set the owning side to null (unless already changed)
            if ($serviceField->getService() === $this) {
                $serviceField->setService(null);
            }
        }

        return $this;
    }
}
