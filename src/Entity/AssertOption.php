<?php

/*
 * This file is part of the API as a Service Project.
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
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * Options for field assertions.
 *
 * @ApiResource()
 * @ApiFilter(
 *     SearchFilter::class,
 *     properties={
 *         "name": "word_start"
 *     }
 * )
 * @ORM\Entity()
 * @author Christian Siewert <christian@sieware.international>
 */
class AssertOption
{
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
     * @ORM\Column(type="string", length=255)
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\FieldAssert", inversedBy="options")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fieldAssert;

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

    public function getFieldAssert(): ?FieldAssert
    {
        return $this->fieldAssert;
    }

    public function setFieldAssert(?FieldAssert $fieldAssert): self
    {
        $this->fieldAssert = $fieldAssert;

        return $this;
    }
}
