<?php

declare(strict_types=1);

namespace Simensen\Sequence\Tests\Unit\Sequences\Adapter;

use Simensen\Sequence\Sequences\Adapter\GlobalInMemorySequences;
use Simensen\Sequence\Sequences\Adapter\InMemorySequences;

/**
 * @extends AbstractInMemorySequencesTestCase<GlobalInMemorySequences>
 */
class GlobalInMemorySequencesTest extends AbstractInMemorySequencesTestCase
{
    protected function getSequencesUnderTest(?int $defaultStartValue = null): InMemorySequences
    {
        $args = isset($defaultStartValue) ? [$defaultStartValue] : [];

        return new GlobalInMemorySequences(...$args);
    }
}
