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
use Symfony\Component\Serializer\Annotation\MaxDepth;
use InvalidArgumentException;

/**
 * Represents a validation constraint for a service field.
 *
 * @ORM\Entity
 * @ApiResource(
 *     routePrefix="/aaas/field",
 *     attributes={
 *         "normalization_context"={
 *             "groups"={"constraint"},
 *             "enable_max_depth" = true
 *         },
 *         "denormalization_context"={
 *             "groups"={"constraint"},
 *             "enable_max_depth" = true
 *         }
 *     }
 * )
 * @ApiFilter(
 *     SearchFilter::class,
 *     properties={
 *         "name": "word_start",
 *         "field" : "exact"
 *     }
 * )
 * @ApiFilter(
 *     GroupFilter::class,
 *     arguments={
 *         "whitelist" : {
 *             "field",
 *             "constraintOption"
 *         }
 *     }
 * )
 * @ORM\Table(name="App_Field_Constraint")
 * @author Christian Siewert <christian@sieware.international>
 */
class Constraint
{
    /**
     * @see https://symfony.com/doc/current/reference/constraints.html#supported-constraints
     *
     * @todo add more validation constraints
     */
    const VALID_CONSTRAINTS = array(
        'NotBlank',
        'Null',
        'NotNull',
        'isNull',
        'isTrue',
        'isFalse',
        'Email',
        'Length',
        'Url',
        'Regex',
        'Ip',
        'Json',
        'EqualTo',
        'NotEqualTo',
        'IdenticalTo',
        'NotIdenticalTo',
        'LessThan',
        'LessThanOrEqual',
        'GreaterThan',
        'GreaterThanOrEqual',
        'Range',
        'DivisibleBy',
        'Unique',
        'Positive',
        'PositiveOrZero',
        'Negative',
        'NegativeOrZero',
        'Date',
        'DateTime',
        'Time',
        'Timezone',
        'Iban',
        'Isbn'
    );

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("constraint")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("constraint")
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="Field", inversedBy="constraints")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("constraint")
     * @MaxDepth(1)
     * @Assert\NotBlank
     */
    private $field;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ConstraintOption", mappedBy="constraint", orphanRemoval=true, cascade={"persist", "remove"})
     * @Groups("constraint")
     * @Assert\Valid
     */
    private $constraintOptions;

    public function __construct()
    {
        $this->constraintOptions = new ArrayCollection();
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
        if (!in_array($name, self::VALID_CONSTRAINTS)) {
            throw new InvalidArgumentException("Invalid type");
        }

        $this->name = $name;

        return $this;
    }

    public function getfield(): ?Field
    {
        return $this->field;
    }

    public function setfield(?Field $field): self
    {
        $this->field = $field;

        return $this;
    }

    /**
     * @return Collection|ConstraintOption[]
     */
    public function getConstraintOptions(): Collection
    {
        return $this->constraintOptions;
    }

    public function addConstraintOption(ConstraintOption $constraintOption): self
    {
        if (!$this->constraintOptions->contains($constraintOption)) {
            $this->constraintOptions[] = $constraintOption;
            $constraintOption->setConstraint($this);
        }

        return $this;
    }

    public function removeConstraintOption(ConstraintOption $constraintOption): self
    {
        if ($this->constraintOptions->contains($constraintOption)) {
            $this->constraintOptions->removeElement($constraintOption);
            // set the owning side to null (unless already changed)
            if ($constraintOption->getConstraint() === $this) {
                $constraintOption->setConstraint(null);
            }
        }

        return $this;
    }
}
