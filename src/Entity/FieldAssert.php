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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * Field assertions.
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
class FieldAssert
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
     * @ORM\OneToMany(targetEntity="App\Entity\AssertOption", mappedBy="fieldAssert", orphanRemoval=true)
     */
    private $options;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ServiceField", inversedBy="assertions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $serviceField;

    public function __construct()
    {
        $this->options = new ArrayCollection();
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

    /**
     * @return Collection|AssertOption[]
     */
    public function getOptions(): Collection
    {
        return $this->options;
    }

    public function addOption(AssertOption $option): self
    {
        if (!$this->options->contains($option)) {
            $this->options[] = $option;
            $option->setFieldAssert($this);
        }

        return $this;
    }

    public function removeOption(AssertOption $option): self
    {
        if ($this->options->contains($option)) {
            $this->options->removeElement($option);
            // set the owning side to null (unless already changed)
            if ($option->getFieldAssert() === $this) {
                $option->setFieldAssert(null);
            }
        }

        return $this;
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
}
