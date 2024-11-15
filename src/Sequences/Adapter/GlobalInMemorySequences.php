<?php

declare(strict_types=1);

namespace Simensen\Sequence\Sequences\Adapter;

final class GlobalInMemorySequences implements InMemorySequences
{
    private ?int $currentValue = null;

    public function __construct(private readonly int $defaultStartValue = 1)
    {
    }

    public function nextValueForSequence(mixed $sequenceClassName): int
    {
        if (!$this->currentValue) {
            $this->currentValue = $this->defaultStartValue - 1;
        }

        return ++$this->currentValue;
    }

    public function registerPotentialCurrentValueForSequence(string $sequenceClassName, int $value): void
    {
        if (!$this->currentValue) {
            $this->currentValue = $this->defaultStartValue - 1;
        }

        $this->currentValue = max($this->currentValue, $value);
    }

    public function forceSetCurrentValueForSequence(string $sequenceClassName, int $value): void
    {
        $this->currentValue = $value;
    }

    public function hasCurrentValueForSequence(string $sequenceClassName): bool
    {
        return !is_null($this->currentValue);
    }

    public function getCurrentValueForSequence(string $sequenceClassName): int
    {
        return $this->currentValue ?? $this->defaultStartValue - 1;
    }
}
