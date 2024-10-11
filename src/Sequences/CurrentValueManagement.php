<?php

declare(strict_types=1);

namespace Simensen\Sequence\Sequences;

use Simensen\Sequence\Sequence\Sequence;

interface CurrentValueManagement
{
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
