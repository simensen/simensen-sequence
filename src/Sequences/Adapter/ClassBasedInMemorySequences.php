<?php

declare(strict_types=1);

namespace Simensen\Sequence\Sequences\Adapter;

use Simensen\Sequence\Sequences\Sequences;

final class ClassBasedInMemorySequences implements Sequences
{
    /**
     * @param array<class-string,array{'next': int}> $setup
     */
    public function __construct(
        private readonly int $defaultNext = 1,
        private array $setup = []
    ) {
    }

    public function nextForSequence(string $sequenceClassName): int
    {
        if (!array_key_exists($sequenceClassName, $this->setup)) {
            $this->setup[$sequenceClassName] = [
                'next' => $this->defaultNext,
            ];
        }

        return $this->setup[$sequenceClassName]['next']++;
    }
}
