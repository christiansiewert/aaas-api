<?= "<?php\n" ?>

namespace <?= $namespace ?>;

<?php if ($api_resource): ?>use ApiPlatform\Core\Annotation\ApiResource;
<?php endif ?>
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Tree\Traits\NestedSetEntity;

/**
<?php if ($api_resource): ?> * @ApiResource()
<?php endif ?>
 * @ORM\Entity(repositoryClass="<?= $repository_full_class_name ?>")
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

    public function getId(): ?int
    {
        return $this->id;
    }
}
