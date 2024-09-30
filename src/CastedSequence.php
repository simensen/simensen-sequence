<?php

declare(strict_types=1);

namespace Simensen\Sequence;

use Simensen\Sequence\Sequence\Behavior\DefaultCastedSequenceBehavior;
use Simensen\Sequence\Sequence\Sequence;

/**
 * @template T
 *
 * @implements Sequence<T>
 */
abstract readonly class CastedSequence implements Sequence
{
    /**
     * @use DefaultCastedSequenceBehavior<T>
     */
    use DefaultCastedSequenceBehavior;
}
