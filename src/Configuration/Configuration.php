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

    public function getSequenceClassName(): string
    {
        return $this->sequenceClassName;
    }

    public function getConnectionName(): ?string
    {
        return $this->connection?->toString();
    }

    public function getCurrentValueColumnName(): ?string
    {
        return $this->currentValueColumn?->toString();
    }

    public function getDefaultStartValue(): ?int
    {
        return $this->defaultStartValue?->toInt();
    }

    public function getName(): ?string
    {
        return $this->name?->toString();
    }

    public function getNameColumnName(): ?string
    {
        return $this->nameColumn?->toString();
    }

    public function getTableName(): ?string
    {
        return $this->table?->toString();
    }
}
