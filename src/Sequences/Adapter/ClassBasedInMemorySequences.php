<?php

declare(strict_types=1);

namespace Simensen\Sequence\Sequences\Adapter;

use Simensen\Sequence\Sequence\Sequence;

final class ClassBasedInMemorySequences implements InMemorySequences
{
    /**
     * @var array<class-string,array{'startValue'?: int, 'currentValue': int}>
     */
    private array $setup;

    /**
     * @param array<class-string,array{'startValue'?: int, 'currentValue'?: int}> $setup
     */
    public function __construct(
        private readonly int $defaultStartValue = 1,
        array $setup = []
    ) {
        $this->setup = [];

        foreach ($setup as $sequenceClassName => $classSpecificSetup) {
            if (!isset($classSpecificSetup['currentValue']) && isset($classSpecificSetup['startValue'])) {
                $this->setup[$sequenceClassName]['currentValue'] = $classSpecificSetup['startValue'] - 1;
            }
        }
    }

    /**
     * @template T
     *
     * @param class-string<Sequence<T>> $sequenceClassName
     */
    private function ensureSequenceIsSetUp(string $sequenceClassName): void
    {
        if (isset($this->setup[$sequenceClassName]['currentValue'])) {
            return;
        }

        if (isset($this->setup[$sequenceClassName]['startValue'])) {
            $this->setup[$sequenceClassName]['currentValue'] = $this->setup[$sequenceClassName]['startValue'] - 1;

            return;
        }

        $this->setup[$sequenceClassName] = [
            'startValue' => $this->defaultStartValue,
            'currentValue' => $this->defaultStartValue - 1,
        ];
    }

    public function nextValueForSequence(string $sequenceClassName): int
    {
        $this->ensureSequenceIsSetUp($sequenceClassName);

        return ++$this->setup[$sequenceClassName]['currentValue'];
    }

    public function registerPotentialCurrentValueForSequence(string $sequenceClassName, int $value): void
    {
        $this->ensureSequenceIsSetUp($sequenceClassName);

        $newCurrentValue = max(
            $this->setup[$sequenceClassName]['currentValue'],
            $value
        );

        $this->setup[$sequenceClassName] = ['currentValue' => $newCurrentValue];
    }

    public function forceSetCurrentValueForSequence(string $sequenceClassName, int $value): void
    {
        $this->setup[$sequenceClassName] = ['currentValue' => $value];
    }

    public function hasCurrentValueForSequence(string $sequenceClassName): bool
    {
        return isset($this->setup[$sequenceClassName]['currentValue']);
    }

    public function getCurrentValueForSequence(string $sequenceClassName): int
    {
        if (isset($this->setup[$sequenceClassName]['currentValue'])) {
            return $this->setup[$sequenceClassName]['currentValue'];
        }

        return $this->defaultStartValue - 1;
    }
}
