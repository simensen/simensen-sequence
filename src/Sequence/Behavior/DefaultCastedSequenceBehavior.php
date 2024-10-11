<?php

declare(strict_types=1);

namespace Simensen\Sequence\Sequence\Behavior;

/**
 * @template T
 */
trait DefaultCastedSequenceBehavior
{
    use BaseSequenceBehavior;

    /**
     * @return T
     */
    abstract protected function cast(int $next): mixed;

    public function next(): mixed
    {
        return $this->cast($this->sequences->nextValueForSequence(static::class));
    }
}
