<?php

declare(strict_types=1);

namespace Simensen\Sequence\Configuration\Behavior;

use ReflectionClass;
use Simensen\Sequence\Configuration\Configuration;
use Simensen\Sequence\Sequence\Column;
use Simensen\Sequence\Sequence\Connection;
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

        /** @var array{'sequenceClassName': class-string<Sequence<T>>, "table"?: Table, "connection"?: Connection, "column"?: Column} $args */
        $args = [
            'sequenceClassName' => $sequenceClassName,
        ];

        foreach ($reflectionClass->getAttributes() as $reflectionAttribute) {
            $attribute = match ($reflectionAttribute->getName()) {
                Table::class, Connection::class, Column::class => $reflectionAttribute->newInstance(),
                default => null,
            };

            if (!$attribute) {
                continue;
            }

            $name = match (true) {
                $attribute instanceof Table => 'table',
                $attribute instanceof Column => 'column',
                $attribute instanceof Connection => 'connection',
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
