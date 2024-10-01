<?php

declare(strict_types=1);

namespace Simensen\Sequence\Tests\Unit\Sequences\Adapter;

use Simensen\Sequence\Sequences\Adapter\GlobalInMemorySequences;
use Simensen\Sequence\Sequences\Sequences;

/**
 * @extends AbstractInMemorySequencesTestCase<GlobalInMemorySequences>
 */
class GlobalInMemorySequencesTestCase extends AbstractInMemorySequencesTestCase
{
    protected function getSequencesUnderTest(): Sequences
    {
        return new GlobalInMemorySequences();
    }
}
