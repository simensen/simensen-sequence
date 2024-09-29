<?php

declare(strict_types=1);

namespace Simensen\Sequence\Sequences\Adapter;

use Simensen\Sequence\Sequences\Sequences;

final class GlobalInMemorySequences implements Sequences
{
    public function __construct(private int $next = 1)
    {
    }

    public function generateForClass(string $sequenceClassName): int
    {
        return $this->next++;
    }
}