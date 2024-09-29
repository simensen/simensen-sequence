<?php

declare(strict_types=1);

namespace Simensen\Sequence\Configuration;

use Simensen\Sequence\Sequence\Column;
use Simensen\Sequence\Sequence\Connection;
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
        private ?Column $column = null,
        private ?Connection $connection = null,
        private ?Table $table = null,
    ) {
    }

    public function getSequenceClassName(): string
    {
        return $this->sequenceClassName;
    }

    public function getColumnName(): ?string
    {
        return $this->column?->toString();
    }

    public function getConnectionName(): ?string
    {
        return $this->connection?->toString();
    }

    public function getTableName(): ?string
    {
        return $this->table?->toString();
    }
}
