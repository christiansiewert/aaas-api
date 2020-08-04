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
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * Represents a filter property.
 *
 * @ORM\Entity
 * @ApiResource(
 *     routePrefix="/aaas/service"
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
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity=Filter::class, inversedBy="properties")
     * @ORM\JoinColumn(nullable=false)
     */
    private $filter;

    /**
     * @ORM\OneToOne(targetEntity=Field::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
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

    public function setField(Field $field): self
    {
        $this->field = $field;

        return $this;
    }
}
