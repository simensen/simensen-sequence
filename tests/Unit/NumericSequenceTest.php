<?php

declare(strict_types=1);

namespace Simensen\Sequence\Tests\Unit;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Simensen\Sequence\Sequences\Adapter\ClassBasedInMemorySequences;
use Simensen\Sequence\Sequences\Adapter\GlobalInMemorySequences;
use Simensen\Sequence\Sequences\Sequences;
use Simensen\Sequence\Tests\Unit\Fixture\FixtureNumericSequence;

class NumericSequenceTest extends TestCase
{
    #[TestDox('calling next() returns $expectedValue from $sequences')]
    #[DataProvider('provideData')]
    public function testNext(int $expectedValue, Sequences $sequences): void
    {
        $fixtureNumericSequence = new FixtureNumericSequence($sequences);

        self::assertSame($expectedValue, $fixtureNumericSequence->next());
    }

    public static function provideData(): array
    {
        return [
            [1, new GlobalInMemorySequences()],
            [2, new GlobalInMemorySequences(defaultStartValue: 2)],
            [3, new GlobalInMemorySequences(defaultStartValue: 3)],
            [4, new GlobalInMemorySequences(defaultStartValue: 4)],
            [5, new GlobalInMemorySequences(defaultStartValue: 5)],

            [1, new ClassBasedInMemorySequences()],
            [2, new ClassBasedInMemorySequences(defaultStartValue: 2)],
            [3, new ClassBasedInMemorySequences(defaultStartValue: 3)],
            [4, new ClassBasedInMemorySequences(defaultStartValue: 4)],
            [5, new ClassBasedInMemorySequences(defaultStartValue: 5)],
        ];
    }
}
