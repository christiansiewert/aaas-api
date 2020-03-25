<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Serializer\Filter\GroupFilter;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * Field Constraint Option.
 *
 * @ORM\Entity
 * @ApiResource(routePrefix="/aaas/field/constraint")
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
 *             "constraint",
 *             "constraintOption"
 *         }
 *     }
 * )
 * @ORM\Table(name="App_Field_Constraint_Option")
 * @author Christian Siewert <christian@sieware.international>
 */
class ConstraintOption
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"constraint", "constraintOption"})
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"constraint", "constraintOption"})
     * @Assert\NotBlank
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Constraint", inversedBy="constraintOptions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $constraint;

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

    public function getConstraint(): ?Constraint
    {
        return $this->constraint;
    }

    public function setConstraint(?Constraint $constraint): self
    {
        $this->constraint = $constraint;

        return $this;
    }
}
