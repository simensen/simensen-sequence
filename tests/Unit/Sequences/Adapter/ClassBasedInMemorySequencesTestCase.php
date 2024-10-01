<?php

declare(strict_types=1);

namespace Simensen\Sequence\Tests\Unit\Sequences\Adapter;

use Simensen\Sequence\Sequences\Adapter\ClassBasedInMemorySequences;
use Simensen\Sequence\Sequences\Sequences;

/**
 * @extends AbstractInMemorySequencesTestCase<ClassBasedInMemorySequences>
 */
class ClassBasedInMemorySequencesTestCase extends AbstractInMemorySequencesTestCase
{
    protected function getSequencesUnderTest(): Sequences
    {
        return new ClassBasedInMemorySequences();
    }
}
