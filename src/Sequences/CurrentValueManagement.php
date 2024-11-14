<?php

declare(strict_types=1);

namespace Simensen\Sequence\Sequences;

use Simensen\Sequence\Sequence\Sequence;

interface CurrentValueManagement
{
    public function hasCurrentValueForSequence(string $sequenceClassName): bool;

    public function getCurrentValueForSequence(string $sequenceClassName): int;

    /**
     * @template T
     *
     * @param class-string<Sequence<T>> $sequenceClassName
     */
    public function registerPotentialCurrentValueForSequence(string $sequenceClassName, int $value): void;

    /**
     * @template T
     *
     * @param class-string<Sequence<T>> $sequenceClassName
     */
    public function forceSetCurrentValueForSequence(string $sequenceClassName, int $value): void;
}
