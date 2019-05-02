<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ApiResource()
 * @ORM\Entity()
 * @ORM\Table(name="App_Relation_Joincolumn")
 *
 * @todo we maybe need some more fields
 */
class RelationJoincolumn
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
    private $referencedColumnName;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isUnique;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isNullable;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\FieldRelation", mappedBy="joinColumn", cascade={"persist", "remove"})
     */
    private $fieldRelation;

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

    public function getReferencedColumnName(): ?string
    {
        return $this->referencedColumnName;
    }

    public function setReferencedColumnName(string $referencedColumnName): self
    {
        $this->referencedColumnName = $referencedColumnName;

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

    public function getFieldRelation(): ?FieldRelation
    {
        return $this->fieldRelation;
    }

    public function setFieldRelation(?FieldRelation $fieldRelation): self
    {
        $this->fieldRelation = $fieldRelation;

        // set (or unset) the owning side of the relation if necessary
        $newJoinColumn = $fieldRelation === null ? null : $this;
        if ($newJoinColumn !== $fieldRelation->getJoinColumn()) {
            $fieldRelation->setJoinColumn($newJoinColumn);
        }

        return $this;
    }
}
