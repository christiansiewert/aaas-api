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
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Serializer\Filter\GroupFilter;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * Key-value pairs of options that get passed to the underlying
 * database platform when generating DDL statements.
 *
 * @ORM\Entity
 * @ApiResource(routePrefix="/field")
 * @ApiFilter(
 *     SearchFilter::class,
 *     properties={
 *         "name": "word_start"
 *     }
 * )
 * @ApiFilter(
 *     GroupFilter::class,
 *     arguments={
 *         "whitelist" : {
 *             "option"
 *         }
 *     }
 * )
 * @ORM\Table(name="App_Field_Option")
 * @author Christian Siewert <christian@sieware.international>
 */
class Option
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("option")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("option")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("option")
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity="Field", inversedBy="options")
     * @ORM\JoinColumn(nullable=false)
     */
    private $serviceField;

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

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getServiceField(): ?Field
    {
        return $this->serviceField;
    }

    public function setServiceField(?Field $serviceField): self
    {
        $this->serviceField = $serviceField;

        return $this;
    }
}
