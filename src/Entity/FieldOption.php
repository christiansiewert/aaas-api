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
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * Key-value pairs of options that get passed to the underlying
 * database platform when generating DDL statements.
 *
 * @ApiResource()
 * @ApiFilter(
 *     SearchFilter::class,
 *     properties={
 *         "name": "word_start"
 *     }
 * )
 * @ORM\Entity()
 * @ORM\Table(name="App_Field_Option")
 * @author Christian Siewert <christian@sieware.international>
 */
class FieldOption
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ServiceField", inversedBy="options")
     * @ORM\JoinColumn(nullable=false)
     */
    private $serviceField;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $defaultValue;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isUnsigned;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $comment;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getServiceField(): ?ServiceField
    {
        return $this->serviceField;
    }

    public function setServiceField(?ServiceField $serviceField): self
    {
        $this->serviceField = $serviceField;

        return $this;
    }

    public function getDefaultValue(): ?string
    {
        return $this->defaultValue;
    }

    public function setDefaultValue(string $defaultValue): self
    {
        $this->defaultValue = $defaultValue;

        return $this;
    }

    public function getIsUnsigned(): ?bool
    {
        return $this->isUnsigned;
    }

    public function setIsUnsigned(bool $isUnsigned): self
    {
        $this->isUnsigned = $isUnsigned;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }
}
