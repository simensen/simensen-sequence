<?php

declare(strict_types=1);

namespace Simensen\Sequence\Configuration;

use Simensen\Sequence\Sequence\Connection;
use Simensen\Sequence\Sequence\CurrentValueColumn;
use Simensen\Sequence\Sequence\DefaultStartValue;
use Simensen\Sequence\Sequence\Name;
use Simensen\Sequence\Sequence\NameColumn;
use Simensen\Sequence\Sequence\Sequence;
use Simensen\Sequence\Sequence\Table;

final readonly class Configuration
{
    /**
     * @template T
     *
     * @param class-string<Sequence<T>> $sequenceClassName
     */
    public function __construct(
        private string $sequenceClassName,
        private ?CurrentValueColumn $currentValueColumn = null,
        private ?Connection $connection = null,
        private ?DefaultStartValue $defaultStartValue = null,
        private ?Name $name = null,
        private ?NameColumn $nameColumn = null,
        private ?Table $table = null,
    ) {
    }

    /**
     * @return class-string<Sequence<*>>
     */
    public function getSequenceClassName(): string
    {
        return $this->sequenceClassName;
    }

    public function getConnectionName(?string $defaultValue = null): ?string
    {
        return $this->connection?->toString() ?? $defaultValue;
    }

    public function getCurrentValueColumnName(?string $defaultValue = null): ?string
    {
        return $this->currentValueColumn?->toString() ?? $defaultValue;
    }

    public function getDefaultStartValue(?int $defaultValue = null): ?int
    {
        return $this->defaultStartValue?->toInt() ?? $defaultValue;
    }

    public function getName(?string $defaultValue = null): ?string
    {
        return $this->name?->toString() ?? $defaultValue = null;
    }

    public function getNameColumnName(?string $defaultValue = null): ?string
    {
        return $this->nameColumn?->toString() ?? $defaultValue = null;
    }

    public function getTableName(?string $defaultValue = null): ?string
    {
        return $this->table?->toString() ?? $defaultValue = null;
    }

    public function withDefaults(
        ?CurrentValueColumn $currentValueColumn = null,
        ?Connection $connection = null,
        ?DefaultStartValue $defaultStartValue = null,
        ?Name $name = null,
        ?NameColumn $nameColumn = null,
        ?Table $table = null,
    ): self {
        return new self(
            $this->sequenceClassName,
            $this->currentValueColumn ?? $currentValueColumn,
            $this->connection ?? $connection,
            $this->defaultStartValue ?? $defaultStartValue,
            $this->name ?? $name,
            $this->nameColumn ?? $nameColumn,
            $this->table ?? $table,
        );
    }
}
