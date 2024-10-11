<?php

declare(strict_types=1);

namespace Simensen\Sequence\Tests\Unit\Sequences\Adapter;

use Simensen\Sequence\Sequences\Adapter\ClassBasedInMemorySequences;
use Simensen\Sequence\Sequences\Adapter\InMemorySequences;

/**
 * @extends AbstractInMemorySequencesTestCase<ClassBasedInMemorySequences>
 */
class ClassBasedInMemorySequencesTest extends AbstractInMemorySequencesTestCase
{
    protected function getSequencesUnderTest(?int $defaultStartValue = null): InMemorySequences
    {
        $args = isset($defaultStartValue) ? [$defaultStartValue] : [];

        return new ClassBasedInMemorySequences(...$args);
    }
}
