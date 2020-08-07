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

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Serializer\Filter\GroupFilter;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * Represents a filter property.
 *
 * @ORM\Entity
 * @ApiResource(
 *     routePrefix="/aaas/service",
 *     normalizationContext={
 *         "groups"={"filterProperty"},
 *         "enable_max_depth" = true
 *     },
 *     denormalizationContext={
 *         "groups"={"filterProperty"},
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
 *             "filter"
 *         }
 *     }
 * )
 * @ORM\Table(name="App_Filter_Property")
 * @author Christian Siewert <christian@sieware.international>
 */
class FilterProperty
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("filterProperty")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("filterProperty")
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity=Filter::class, inversedBy="properties")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Valid
     * @MaxDepth(1)
     * @Groups("filterProperty")
     */
    private $filter;

    /**
     * @ORM\ManyToOne(targetEntity=Field::class)
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Valid
     * @MaxDepth(1)
     * @Groups("filterProperty")
     */
    private $field;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getFilter(): ?Filter
    {
        return $this->filter;
    }

    public function setFilter(?Filter $filter): self
    {
        $this->filter = $filter;

        return $this;
    }

    public function getField(): ?Field
    {
        return $this->field;
    }

    public function setField(?Field $field): self
    {
        $this->field = $field;

        return $this;
    }
}
