<?php

declare(strict_types=1);

namespace Simensen\Sequence\Sequence\Behavior;

use Simensen\Sequence\Sequences\Sequences;

trait BaseSequenceBehavior
{
    public function __construct(protected readonly Sequences $sequences)
    {
    }
}
