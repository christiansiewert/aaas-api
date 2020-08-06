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

use InvalidArgumentException;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use ApiPlatform\Core\Serializer\Filter\GroupFilter;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * Represents a filter on a repository service.
 *
 * @ORM\Entity
 * @ApiResource(
 *     routePrefix="/aaas/service",
 *     normalizationContext={
 *         "groups"={"filter"},
 *         "enable_max_depth" = true
 *     },
 *     denormalizationContext={
 *         "groups"={"filter"},
 *         "enable_max_depth" = true
 *     }
 * )
 * @ApiFilter(
 *     SearchFilter::class,
 *     properties={
 *         "type": "word_start",
 *         "service" : "exact"
 *     }
 * )
 * @ApiFilter(
 *     GroupFilter::class,
 *     arguments={
 *         "whitelist" : {
 *             "service",
 *             "filterProperty"
 *         }
 *     }
 * )
 * @ORM\Table(name="App_Service_Filter")
 * @author Christian Siewert <christian@sieware.international>
 */
class Filter
{
    /**
     * Valid filter types.
     *
     * @todo implement more filter types
     */
    const VALID_TYPES = array(
        'string' => 'SearchFilter',
        'date' => 'DateFilter',
        'boolean' => 'BooleanFilter',
        'numeric' => 'NumericFilter',
        'range' => 'RangeFilter',
        'exists' => 'ExistsFilter',
        'order' => 'OrderFilter'
    );

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("filter")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     * @Assert\NotBlank
     * @Groups("filter")
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=Service::class, inversedBy="filters")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank
     * @Groups("filter")
     * @MaxDepth(1)
     * @Assert\Valid
     */
    private $service;

    /**
     * @ORM\OneToMany(targetEntity=FilterProperty::class, mappedBy="filter", orphanRemoval=true, cascade={"persist", "remove"})
     * @Groups("filter")
     * @MaxDepth(1)
     * @Assert\Valid
     */
    private $properties;

    public function __construct()
    {
        $this->properties = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        if (!isset(self::VALID_TYPES[$type])) {
            throw new InvalidArgumentException("Invalid type");
        }

        $this->type = $type;

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
     * @return Collection|FilterProperty[]
     */
    public function getProperties(): Collection
    {
        return $this->properties;
    }

    public function addProperty(FilterProperty $property): self
    {
        if (!$this->properties->contains($property)) {
            $this->properties[] = $property;
            $property->setFilter($this);
        }

        return $this;
    }

    public function removeProperty(FilterProperty $property): self
    {
        if ($this->properties->contains($property)) {
            $this->properties->removeElement($property);
            // set the owning side to null (unless already changed)
            if ($property->getFilter() === $this) {
                $property->setFilter(null);
            }
        }

        return $this;
    }
}
