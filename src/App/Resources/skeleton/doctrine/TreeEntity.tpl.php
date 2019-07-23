<?= "<?php\n" ?>

/*
 * This file is part of API as a Service.
 *
 * Copyright (c) 2019 Christian Siewert <christian@sieware.international>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace <?= $namespace ?>;

<?php if ($api_resource): ?>use ApiPlatform\Core\Annotation\ApiResource;
<?php endif ?>
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Tree\Traits\NestedSetEntity;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
<?php if ($api_resource): ?> * @ApiResource(routePrefix="/api")
<?php endif ?>
 * @ORM\Entity(repositoryClass="<?= $repository_full_class_name ?>")
 * @ORM\Table(name="Api_<?= $class_name ?>")
 * @Gedmo\Tree(type="nested")
 */
class <?= $class_name."\n" ?>
{
    use NestedSetEntity;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Gedmo\TreeParent
     * @ORM\ManyToOne(targetEntity="<?= $class_name ?>", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="<?= $class_name ?>", mappedBy="parent")
     * @ORM\OrderBy({"left" = "ASC"})
     */
    private $children;

    public function __construct()
    {
        $this->children = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setParent(<?= $class_name ?> $parent = null)
    {
        $this->parent = $parent;
    }

    public function getParent()
    {
        return $this->parent;
    }

    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChildren(<?= $class_name ?> $children): self
    {
        if (!$this->children->contains($children)) {
            $this->children[] = $children;
            $children->setParent($this);
        }

        return $this;
    }

    public function removeChildren(<?= $class_name ?> $children): self
    {
        if ($this->children->contains($children)) {
            $this->children->removeElement($children);
            // set the owning side to null (unless already changed)
            if ($children->getParent() === $this) {
                $children->setParent(null);
            }
        }

        return $this;
    }
}
