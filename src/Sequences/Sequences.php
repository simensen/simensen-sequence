<?php

declare(strict_types=1);

namespace Simensen\Sequence\Sequences;

use Simensen\Sequence\Sequence\Sequence;

interface Sequences
{
    /**
     * @template T
     *
     * @param class-string<Sequence<T>> $sequenceClassName
     */
    public function generateForClass(string $sequenceClassName): int;
}
