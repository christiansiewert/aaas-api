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
 * Field assertions.
 *
 * @ORM\Entity
 * @ApiResource(routePrefix="/field")
 * @ApiFilter(
 *     SearchFilter::class,
 *     properties={
 *         "name": "word_start"
 *     }
 * )
 * @ORM\Table(name="App_Field_Assert")
 * @author Christian Siewert <christian@sieware.international>
 */
class Constraint
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
     * @ORM\ManyToOne(targetEntity="Field", inversedBy="constraints")
     * @ORM\JoinColumn(nullable=false)
     */
    private $field;

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

    public function getfield(): ?Field
    {
        return $this->field;
    }

    public function setfield(?Field $field): self
    {
        $this->field = $field;

        return $this;
    }
}
