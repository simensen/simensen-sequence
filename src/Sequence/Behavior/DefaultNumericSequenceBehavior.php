<?php

declare(strict_types=1);

namespace Simensen\Sequence\Sequence\Behavior;

trait DefaultNumericSequenceBehavior
{
    use BaseSequenceBehavior;

    public function next(): int
    {
        return $this->sequences->nextForSequence(static::class);
    }
}
