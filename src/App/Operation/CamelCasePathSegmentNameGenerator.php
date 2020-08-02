<?php

/*
 * This file is part of API as a Service.
 *
 * Copyright (c) 2019 Christian Siewert <christian@sieware.international>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Operation;

use ApiPlatform\Core\Util\Inflector;
use ApiPlatform\Core\Operation\PathSegmentNameGeneratorInterface;

/**
 * Finds camel case path names and seperate it by a slash
 *
 * @author Christian Siewert <christian@sieware.international>
 */
class CamelCasePathSegmentNameGenerator implements PathSegmentNameGeneratorInterface
{
    /**
     * @inheritDoc
     */
    public function getSegmentName(string $name, bool $collection = true): string
    {
        return $collection ? $this->slashize(Inflector::pluralize($name)) : $this->slashize($name);
    }

    /**
     * @param string $string
     * @return string
     */
    private function slashize(string $string): string
    {
        return strtolower(preg_replace('~(?<=\\w)([A-Z])~', '/$1', $string));
    }
}