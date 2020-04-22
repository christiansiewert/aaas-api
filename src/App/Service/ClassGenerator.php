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
use \Exception;

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
     * @param FileManager $fileManager
     */
    public function __construct(Generator $generator, FileManager $fileManager)
    {
        $this->generator = $generator;
        $this->fileManager = $fileManager;
    }

    /**
     * @param Service $service
     * @return string
     * @throws Exception
     */
    public function generateEntityClass(Service $service) : string
    {
        $name = $service->getName();
        $type = $service->getType();

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
                'repository_full_class_name' => sprintf(self::REPOSITORY_NAMESPACE, $name),
                'project_repository' => strtolower($service->getRepository()->getName())
            ]
        );
    }

    /**
     * @param Service $service
     * @return string
     * @throws Exception
     */
    public function generateRepositoryClass(Service $service) : string
    {
        $name = $service->getName();
        $type = $service->getType();

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
        return dirname(__DIR__).sprintf(self::TEMPLATE_PATH, $template);
    }

    /**
     * @param string $annotationClass The annotation: e.g. "@ORM\Column"
     * @param array  $options         Key-value pair of options for the annotation
     *
     * @return string
     */
    public function buildAnnotationLine(string $annotationClass, array $options)
    {
        $formattedOptions = array_map(function ($option, $value) {
            if (is_array($value)) {
                if (!isset($value[0])) {
                    return sprintf('%s={%s}', $option, implode(', ', array_map(function ($val, $key) {
                        return sprintf('"%s" = %s', $key, $this->quoteAnnotationValue($val));
                    }, $value, array_keys($value))));
                }

                return sprintf('%s={%s}', $option, implode(', ', array_map(function ($val) {
                    return $this->quoteAnnotationValue($val);
                }, $value)));
            }

            return sprintf('%s=%s', $option, $this->quoteAnnotationValue($value));
        }, array_keys($options), array_values($options));

        return sprintf('%s(%s)', $annotationClass, implode(', ', $formattedOptions));
    }

    private function quoteAnnotationValue($value)
    {
        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }

        if (null === $value) {
            return 'null';
        }

        if (is_int($value) || '0' === $value) {
            return $value;
        }

        if (is_array($value)) {
            throw new Exception('Invalid value: loop before quoting.');
        }

        return sprintf('"%s"', $value);
    }
}
