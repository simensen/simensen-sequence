<?php

declare(strict_types=1);

namespace Simensen\Sequence\Sequences\Adapter;

final class GlobalInMemorySequences implements InMemorySequences
{
    private int $currentValue;

    public function __construct(int $defaultStartValue = 1)
    {
        $this->currentValue = $defaultStartValue - 1;
    }

    public function nextValueForSequence(mixed $sequenceClassName): int
    {
        return ++$this->currentValue;
    }

    public function registerPotentialCurrentValueForSequence(string $sequenceClassName, int $value): void
    {
        $this->currentValue = max($this->currentValue, $value);
    }

    public function forceSetCurrentValueForSequence(string $sequenceClassName, int $value): void
    {
        $this->currentValue = $value;
    }
}
