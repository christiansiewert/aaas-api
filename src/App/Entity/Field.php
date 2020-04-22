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
 * A Field represents a column in your database table.
 *
 * @ORM\Entity
 * @ApiResource(routePrefix="/service")
 * @ApiFilter(
 *     SearchFilter::class,
 *     properties={
 *         "name": "word_start",
 *         "description" : "word_start",
 *         "service" : "exact"
 *     }
 * )
 * @ApiFilter(
 *     GroupFilter::class,
 *     arguments={
 *         "whitelist" : {
 *             "field",
 *             "option",
 *             "constraint",
 *             "relation"
 *         }
 *     }
 * )
 * @ORM\Table(name="App_Service_Field")
 * @author Christian Siewert <christian@sieware.international>
 */
class Field
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
        'decimal',
        'date',
        'time',
        'datetime',
        'relation'
    );

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("field")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("field")
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups("field")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, options={"default" : "string"})
     * @Groups("field")
     * @Assert\NotBlank
     */
    private $dataType = 'string';

    /**
     * @ORM\Column(type="integer", nullable=true, options={"unsigned"=true})
     * @Groups("field")
     */
    private $length;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups("field")
     */
    private $dataTypePrecision = null;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups("field")
     */
    private $dataTypeScale = null;

    /**
     * @ORM\Column(type="boolean", options={"default" : false})
     * @Groups("field")
     */
    private $isUnique = false;

    /**
     * @ORM\Column(type="boolean", options={"default" : false})
     * @Groups("field")
     */
    private $isNullable = false;

    /**
     * @ORM\ManyToOne(targetEntity="Service", inversedBy="fields")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank
     */
    private $service;

    /**
     * Key-value pairs of options that get passed to the underlying
     * database platform when generating DDL statements.
     *
     * @ORM\OneToMany(targetEntity="FieldOption", mappedBy="field", orphanRemoval=true)
     * @Groups({"field", "option"})
     * @Assert\Valid
     */
    private $fieldOptions;

    /**
     * @ORM\OneToMany(targetEntity="Constraint", mappedBy="field", orphanRemoval=true)
     * @Groups({"field", "constraint"})
     * @Assert\Valid
     */
    private $constraints;

    /**
     * @ORM\OneToOne(targetEntity="Relation", inversedBy="field", cascade={"persist", "remove"})
     * @Groups({"field", "relation"})
     * @Assert\Valid
     */
    private $relation;

    public function __construct()
    {
        $this->fieldOptions = new ArrayCollection();
        $this->constraints = new ArrayCollection();
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

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function setService(?Service $service): self
    {
        $this->service = $service;

        return $this;
    }

    /**
     * @return Collection|FieldOption[]
     */
    public function getFieldOptions(): Collection
    {
        return $this->fieldOptions;
    }

    public function addFieldOption(FieldOption $fieldOption): self
    {
        if (!$this->fieldOptions->contains($fieldOption)) {
            $this->fieldOptions[] = $fieldOption;
            $fieldOption->setfield($this);
        }

        return $this;
    }

    public function removeFieldOption(FieldOption $fieldOption): self
    {
        if ($this->fieldOptions->contains($fieldOption)) {
            $this->fieldOptions->removeElement($fieldOption);
            // set the owning side to null (unless already changed)
            if ($fieldOption->getfield() === $this) {
                $fieldOption->setfield(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Constraint[]
     */
    public function getConstraints(): Collection
    {
        return $this->constraints;
    }

    public function addConstraint(Constraint $constraint): self
    {
        if (!$this->constraints->contains($constraint)) {
            $this->constraints[] = $constraint;
            $constraint->setfield($this);
        }

        return $this;
    }

    public function removeAssertion(Constraint $constraint): self
    {
        if ($this->constraints->contains($constraint)) {
            $this->constraints->removeElement($constraint);
            // set the owning side to null (unless already changed)
            if ($constraint->getfield() === $this) {
                $constraint->setfield(null);
            }
        }

        return $this;
    }

    public function getRelation(): ?Relation
    {
        return $this->relation;
    }

    public function setRelation(?Relation $relation): self
    {
        $this->relation = $relation;

        return $this;
    }
}
