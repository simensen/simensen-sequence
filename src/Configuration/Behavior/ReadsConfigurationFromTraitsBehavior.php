<?php

declare(strict_types=1);

namespace Simensen\Sequence\Configuration\Behavior;

use ReflectionClass;
use Simensen\Sequence\Configuration\Configuration;
use Simensen\Sequence\Sequence\Connection;
use Simensen\Sequence\Sequence\CurrentValueColumn;
use Simensen\Sequence\Sequence\DefaultStartValue;
use Simensen\Sequence\Sequence\Name;
use Simensen\Sequence\Sequence\NameColumn;
use Simensen\Sequence\Sequence\Sequence;
use Simensen\Sequence\Sequence\Table;

/**
 * @phpstan-import-type ConfigurationArgs from Configuration
 * @phpstan-import-type ConfigurationPartialArgs from Configuration
 */
trait ReadsConfigurationFromTraitsBehavior
{
    /**
     * @param class-string<Sequence<*>> $sequenceClassName
     */
    public function readSequenceConfigurationForClass(string $sequenceClassName): Configuration
    {
        $reflectionClass = new ReflectionClass($sequenceClassName);

        /** @var ConfigurationArgs $args */
        $args = [
            'sequenceClassName' => $sequenceClassName,
        ] + $this->readSequenceConfigurationArgsForClass($reflectionClass);

        return new Configuration(...$args);
    }

    /**
     * @param ReflectionClass<*> $reflectionClass
     *
     * @return ConfigurationPartialArgs
     */
    protected function readSequenceConfigurationArgsForClass(ReflectionClass $reflectionClass): array
    {
        $args = [];

        foreach ($reflectionClass->getAttributes() as $reflectionAttribute) {
            $attribute = match ($reflectionAttribute->getName()) {
                Connection::class, CurrentValueColumn::class, DefaultStartValue::class, Name::class, NameColumn::class, Table::class => $reflectionAttribute->newInstance(),
                default => null,
            };

            if (!$attribute) {
                continue;
            }

            $name = match (true) {
                $attribute instanceof Connection => 'connection',
                $attribute instanceof CurrentValueColumn => 'currentValueColumn',
                $attribute instanceof DefaultStartValue => 'defaultStartValue',
                $attribute instanceof Name => 'name',
                $attribute instanceof NameColumn => 'nameColumn',
                $attribute instanceof Table => 'table',
                default => null // @codeCoverageIgnore
            };

            if (!$name) {
                continue; // @codeCoverageIgnore
            }

            $args[$name] = $attribute;
        }

        /**
         * @var ConfigurationPartialArgs $args
         */
        if ($parentClassReflection = $reflectionClass->getParentClass()) {
            $parentArgs = $this->readSequenceConfigurationArgsForClass(
                $parentClassReflection,
            );

            $args += $parentArgs;
        }

        return $args;
    }
}
