<?php

namespace Aligent\FixturesBundle\Initializer;

use Oro\Component\DoctrineUtils\Inflector\InflectorFactory;

trait NameNormalizerTrait
{
    private function normalizeName(string $name): string
    {
        $inflector = InflectorFactory::create();
        $name = strtolower($name);
        $name = $inflector->camelize($name);
        return $inflector->tableize($name);
    }
}
