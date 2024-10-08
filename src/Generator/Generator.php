<?php

namespace Dayploy\JsDtoBundle\Generator;

use ReflectionClass;
use Dayploy\JsDtoBundle\Attributes\AnnotationCollectionFactory;
use Dayploy\JsDtoBundle\Generator\EntityGenerator;

class Generator
{
    public function __construct(
        private EntityGenerator $entityGenerator
    ) {
    }

    public function generate(array $directories): void
    {
        $factoryAnnotation = new AnnotationCollectionFactory($directories);
        $classes = $factoryAnnotation->create();

        /** @var ReflectionClass $reflectionClass */
        foreach ($classes as $class => $reflectionClass) {
            $this->entityGenerator->writeEntityClass($reflectionClass);
        }
    }
}
