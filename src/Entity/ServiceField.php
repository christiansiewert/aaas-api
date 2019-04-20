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

/**
 * A ServiceField represents a column in your database table.
 *
 * @ApiResource()
 * @ORM\Entity()
 * @author Christian Siewert <christian@sieware.international>
 */
class ServiceField
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
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $dataType;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $length;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isUnique;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isNullable;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $dataTypePrecision;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $dataTypeScale;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Service", inversedBy="serviceFields")
     * @ORM\JoinColumn(nullable=false)
     */
    private $service;

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
        $this->dataType = $dataType;

        return $this;
    }

    public function getLength(): ?string
    {
        return $this->length;
    }

    public function setLength(string $length): self
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

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function setService(?Service $service): self
    {
        $this->service = $service;

        return $this;
    }
}
