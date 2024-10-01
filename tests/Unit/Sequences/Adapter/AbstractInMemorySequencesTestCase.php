<?php

declare(strict_types=1);

namespace Simensen\Sequence\Tests\Unit\Sequences\Adapter;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Simensen\Sequence\Sequences\Sequences;
use Simensen\Sequence\Tests\Unit\Fixture\FixtureNumericSequence;
use Simensen\Sequence\Tests\Unit\Fixture\Service\ServiceId;
use Simensen\Sequence\Tests\Unit\Fixture\Service\ServiceIdSequence;
use Simensen\Sequence\Tests\Unit\Fixture\User\UserId;
use Simensen\Sequence\Tests\Unit\Fixture\User\UserIdSequence;

/**
 * @template T
 */
abstract class AbstractInMemorySequencesTestCase extends TestCase
{
    /**
     * @return Sequences<T>
     */
    abstract protected function getSequencesUnderTest(): Sequences;

    #[DataProvider('provideData')]
    public function testNextByClassName(string $sequenceClassName, mixed $expectedNext): void
    {
        $sequences = $this->getSequencesUnderTest();

        $sequence = new $sequenceClassName($sequences);

        self::assertInstanceOf($sequenceClassName, $sequence);
        self::assertEquals($expectedNext, $sequence->next());
    }

    public static function provideData(): array
    {
        return [
            [FixtureNumericSequence::class, 1],
            [ServiceIdSequence::class, ServiceId::fromInt(1)],
            [UserIdSequence::class, UserId::fromInt(1)],
        ];
    }
}
