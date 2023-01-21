<?php

namespace Evmv\TelegramBot\Helper\ClassHelper;

use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;
use Evmv\TelegramBot\Handle\HandleEnum;

class ClassHelper
{
    public function __construct(#[TaggedIterator('telegram.general')] private readonly iterable $handlers)
    {
    }

    public function getClassesByInterface(HandleEnum $enum): array
    {
        $classes = [];

        foreach ($this->handlers as $handler) {
            if (is_a($handler, $enum->value)) {
                $classes[] = $handler;
            }
        }

        return $classes;
    }

    public function getClassAttribute(string $className, string $attributeName): array
    {
        $reflectionClass = new \ReflectionClass($className);

        return $reflectionClass->getAttributes($attributeName)[0]->getArguments();
    }

    public function getClassAttributes(string $className, string $attributeName): array
    {
        $reflectionClass = new \ReflectionClass($className);

        return $reflectionClass->getAttributes($attributeName);
    }
}
