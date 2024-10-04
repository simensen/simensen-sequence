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

trait ReadsConfigurationFromTraitsBehavior
{
    /**
     * @template T
     *
     * @param class-string<Sequence<T>> $sequenceClassName
     */
    public function readSequenceConfigurationForClass(string $sequenceClassName): Configuration
    {
        $reflectionClass = new ReflectionClass($sequenceClassName);

        /** @var array{'sequenceClassName': class-string<Sequence<T>>, "connection"?: Connection, "currentValueColumn"?: CurrentValueColumn, "defaultStartValue"?: DefaultStartValue, "name"?: Name, "nameColumn"?: NameColumn, "table"?: Table} $args */
        $args = [
            'sequenceClassName' => $sequenceClassName,
        ];

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

        return new Configuration(...$args);
    }
}
