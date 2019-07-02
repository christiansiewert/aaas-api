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
use InvalidArgumentException;

/**
 * A ServiceField represents a column in your database table.
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
 * @ORM\Table(name="App_Service_Field")
 * @author Christian Siewert <christian@sieware.international>
 */
class ServiceField
{
    /**
     * @see https://www.doctrine-project.org/projects/doctrine-dbal/en/2.9/reference/types.html#types
     */
    const VALID_DATA_TYPES = array(
        'string',
        'integer',
        'boolean',
        'text',
        'float',
        'date',
        'time',
        'datetime'
    );

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
     * @ORM\Column(type="string", length=255, options={"default" : "string"})
     */
    private $dataType = 'string';

    /**
     * @ORM\Column(type="integer", nullable=true, options={"default" : 255, "unsigned"=true})
     */
    private $length = 255;

    /**
     * @ORM\Column(type="boolean", options={"default" : false})
     */
    private $isUnique = false;

    /**
     * @ORM\Column(type="boolean", options={"default" : false})
     */
    private $isNullable = false;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $dataTypePrecision;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $dataTypeScale;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\RepositoryService", inversedBy="serviceFields")
     * @ORM\JoinColumn(nullable=false)
     */
    private $service;

    /**
     * Key-value pairs of options that get passed to the underlying
     * database platform when generating DDL statements.
     *
     * @ORM\OneToMany(targetEntity="App\Entity\FieldOption", mappedBy="serviceField", orphanRemoval=true)
     */
    private $options;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\FieldAssert", mappedBy="serviceField", orphanRemoval=true)
     */
    private $assertions;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\FieldRelation", inversedBy="serviceField", cascade={"persist", "remove"})
     */
    private $relation;

    public function __construct()
    {
        $this->options = new ArrayCollection();
        $this->assertions = new ArrayCollection();
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

    public function getDataType(): ?string
    {
        return $this->dataType;
    }

    public function setDataType(string $dataType): self
    {
        if (!in_array($dataType, self::VALID_DATA_TYPES)) {
            throw new InvalidArgumentException("Invalid type");
        }

        $this->dataType = $dataType;

        return $this;
    }

    public function getLength(): ?int
    {
        return $this->length;
    }

    public function setLength(?int $length): self
    {
        $this->length = $length;

        return $this;
    }

    public function getIsUnique(): ?bool
    {
        return $this->isUnique;
    }

    public function setIsUnique(bool $isUnique): self
    {
        $this->isUnique = $isUnique;

        return $this;
    }

    public function getIsNullable(): ?bool
    {
        return $this->isNullable;
    }

    public function setIsNullable(bool $isNullable): self
    {
        $this->isNullable = $isNullable;

        return $this;
    }

    public function getDataTypePrecision(): ?int
    {
        return $this->dataTypePrecision;
    }

    public function setDataTypePrecision(?int $dataTypePrecision): self
    {
        $this->dataTypePrecision = $dataTypePrecision;

        return $this;
    }

    public function getDataTypeScale(): ?int
    {
        return $this->dataTypeScale;
    }

    public function setDataTypeScale(?int $dataTypeScale): self
    {
        $this->dataTypeScale = $dataTypeScale;

        return $this;
    }

    public function getService(): ?RepositoryService
    {
        return $this->service;
    }

    public function setService(?RepositoryService $service): self
    {
        $this->service = $service;

        return $this;
    }

    /**
     * @return Collection|FieldOption[]
     */
    public function getOptions(): Collection
    {
        return $this->options;
    }

    public function addOption(FieldOption $option): self
    {
        if (!$this->options->contains($option)) {
            $this->options[] = $option;
            $option->setServiceField($this);
        }

        return $this;
    }

    public function removeOption(FieldOption $option): self
    {
        if ($this->options->contains($option)) {
            $this->options->removeElement($option);
            // set the owning side to null (unless already changed)
            if ($option->getServiceField() === $this) {
                $option->setServiceField(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|FieldAssert[]
     */
    public function getAssertions(): Collection
    {
        return $this->assertions;
    }

    public function addAssertion(FieldAssert $assertion): self
    {
        if (!$this->assertions->contains($assertion)) {
            $this->assertions[] = $assertion;
            $assertion->setServiceField($this);
        }

        return $this;
    }

    public function removeAssertion(FieldAssert $assertion): self
    {
        if ($this->assertions->contains($assertion)) {
            $this->assertions->removeElement($assertion);
            // set the owning side to null (unless already changed)
            if ($assertion->getServiceField() === $this) {
                $assertion->setServiceField(null);
            }
        }

        return $this;
    }

    public function getRelation(): ?FieldRelation
    {
        return $this->relation;
    }

    public function setRelation(?FieldRelation $relation): self
    {
        $this->relation = $relation;

        return $this;
    }
}
