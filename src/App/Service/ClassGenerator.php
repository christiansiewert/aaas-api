<?php

/*
 * This file is part of API as a Service.
 *
 * Copyright (c) 2019 Christian Siewert <christian@sieware.international>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Service;

use App\Entity\Service;
use Symfony\Bundle\MakerBundle\FileManager;
use Symfony\Bundle\MakerBundle\Generator;

/**
 * @author Christian Siewert <christian@sieware.international>
 */
class ClassGenerator
{
    /**
     * Template path for our class templates
     */
    const TEMPLATE_PATH = '/Resources/skeleton/doctrine/%s';

    /**
     * Namespaces to use for our generated entities and repositories
     */
    const ENTITY_NAMESPACE = 'Aaas\\Entity\\%s';
    const REPOSITORY_NAMESPACE  = 'Aaas\\Repository\\%sRepository';

    /**
     * @var Generator
     */
    public $generator;

    /**
     * @var FileManager
     */
    private $fileManager;

    /**
     * @param Generator $generator
     */
    public function __construct(Generator $generator, FileManager $fileManager)
    {
        $this->generator = $generator;
        $this->fileManager = $fileManager;
    }

    /**
     * @param string $name
     * @param string $type
     * @return string
     * @throws \Exception
     */
    public function generateEntityClass(string $name, string $type = Service::TYPE_LIST) : string
    {
        $template = $type === Service::TYPE_TREE ? 'TreeEntity.tpl.php' : 'Entity.tpl.php';
        $targetPath = $this->fileManager->getRelativePathForFutureClass(sprintf(self::ENTITY_NAMESPACE, $name));

        if ($this->fileManager->fileExists($targetPath)) {
            unlink($this->fileManager->absolutizePath($targetPath));
        }

        return $this->generator->generateClass(
            sprintf(self::ENTITY_NAMESPACE, $name),
            $this->getTemplatePath($template),
            [
                'api_resource' => true,
                'repository_full_class_name' => sprintf(self::REPOSITORY_NAMESPACE, $name)
            ]
        );
    }

    /**
     * @param string $name
     * @param string $type
     * @return string
     * @throws \Exception
     */
    public function generateRepositoryClass(string $name, string $type = Service::TYPE_LIST) : string
    {
        $template = $type === Service::TYPE_TREE ? 'TreeRepository.tpl.php' : 'Repository.tpl.php';
        $targetPath = $this->fileManager->getRelativePathForFutureClass(sprintf(self::REPOSITORY_NAMESPACE, $name));

        if ($this->fileManager->fileExists($targetPath)) {
            unlink($this->fileManager->absolutizePath($targetPath));
        }

        return $this->generator->generateClass(
            sprintf(self::REPOSITORY_NAMESPACE, $name),
            $this->getTemplatePath($template),
            [
                'entity_full_class_name' => sprintf(self::ENTITY_NAMESPACE, $name),
                'entity_class_name' => $name,
                'entity_alias' => lcfirst($name)[0],
            ]
        );
    }

    /**
     * @param string $template
     * @return string
     */
    public function getTemplatePath(string $template = 'Entity.tpl.php') : string
    {
        return dirname(__DIR__) . sprintf(self::TEMPLATE_PATH, $template);
    }
}