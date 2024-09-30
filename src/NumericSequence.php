<?php

declare(strict_types=1);

namespace Simensen\Sequence;

use Simensen\Sequence\Sequence\Behavior\DefaultNumericSequenceBehavior;
use Simensen\Sequence\Sequence\Sequence;

/**
 * @implements Sequence<int>
 */
abstract readonly class NumericSequence implements Sequence
{
    use DefaultNumericSequenceBehavior;
}
