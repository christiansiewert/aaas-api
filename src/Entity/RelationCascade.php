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
use InvalidArgumentException;

/**
 * This maps cascade options of field relations.
 *
 * @ApiResource()
 * @ORM\Entity()
 * @ORM\Table(name="App_Relation_Cascade")
 */
class RelationCascade
{
    /**
     * Valid cascade operations
     */
    const CASCADE_OPERATIONS = array(
        'persist',
        'remove',
        'merge',
        'detach',
        'refresh',
        'all'
    );

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\FieldRelation", inversedBy="cascades")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fieldRelation;

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
        if (!in_array($value, self::CASCADE_OPERATIONS)) {
            throw new InvalidArgumentException('NIL');
        }

        $this->value = $value;

        return $this;
    }

    public function getFieldRelation(): ?FieldRelation
    {
        return $this->fieldRelation;
    }

    public function setFieldRelation(?FieldRelation $fieldRelation): self
    {
        $this->fieldRelation = $fieldRelation;

        return $this;
    }
}
