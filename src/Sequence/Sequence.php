<?php

declare(strict_types=1);

namespace Simensen\Sequence\Sequence;

/**
 * @template T
 */
interface Sequence
{
    /**
     * @return T
     */
    public function next(): mixed;
}
