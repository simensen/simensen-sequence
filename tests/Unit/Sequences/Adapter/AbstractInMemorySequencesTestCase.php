<?php

declare(strict_types=1);

namespace Simensen\Sequence\Tests\Unit\Sequences\Adapter;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Simensen\Sequence\Sequence\Sequence;
use Simensen\Sequence\Sequences\Adapter\InMemorySequences;
use Simensen\Sequence\Sequences\CurrentValueManagement;
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
    abstract protected function getSequencesUnderTest(?int $defaultStartValue = null): InMemorySequences;

    #[DataProvider('provideNextByClassNameData')]
    public function testNextByClassName(string $sequenceClassName, mixed $expectedNext): void
    {
        $sequences = $this->getSequencesUnderTest();

        $sequence = new $sequenceClassName($sequences);

        self::assertInstanceOf($sequenceClassName, $sequence);
        self::assertEquals($expectedNext, $sequence->next());
    }

    public static function provideNextByClassNameData(): array
    {
        return [
            [FixtureNumericSequence::class, 1],
            [ServiceIdSequence::class, ServiceId::fromInt(1)],
            [UserIdSequence::class, UserId::fromInt(1)],
        ];
    }

    /**
     * @template T2
     *
     * @param class-string<Sequence<T2>> $sequenceClassName
     */
    #[DataProvider('provideRegisterPotentialCurrentValueForSequenceData')]
    public function testRegisterPotentialCurrentValueForSequence(
        string $sequenceClassName,
        mixed $defaultStartValue,
        mixed $registeredPotentialCurrentValue,
        mixed $expectedNext
    ): void {
        /** @var CurrentValueManagement $sequences */
        $sequences = $this->getSequencesUnderTest($defaultStartValue);
        $sequences->registerPotentialCurrentValueForSequence(
            $sequenceClassName,
            $registeredPotentialCurrentValue
        );

        $sequence = new $sequenceClassName($sequences);

        self::assertInstanceOf($sequenceClassName, $sequence);
        self::assertEquals($expectedNext, $sequence->next());
    }

    public static function provideRegisterPotentialCurrentValueForSequenceData(): array
    {
        return [
            [FixtureNumericSequence::class, 3, 1, 3],
            [ServiceIdSequence::class, 3, 1, ServiceId::fromInt(3)],
            [UserIdSequence::class, 3, 1, UserId::fromInt(3)],

            [FixtureNumericSequence::class, 12, 5, 12],
            [ServiceIdSequence::class, 12, 5, ServiceId::fromInt(12)],
            [UserIdSequence::class, 12, 5, UserId::fromInt(12)],

            [FixtureNumericSequence::class, 12, 11, 12],
            [ServiceIdSequence::class, 12, 11, ServiceId::fromInt(12)],
            [UserIdSequence::class, 12, 11, UserId::fromInt(12)],

            [FixtureNumericSequence::class, 12, 12, 13],
            [ServiceIdSequence::class, 12, 12, ServiceId::fromInt(13)],
            [UserIdSequence::class, 12, 12, UserId::fromInt(13)],

            [FixtureNumericSequence::class, 12, 13, 14],
            [ServiceIdSequence::class, 12, 13, ServiceId::fromInt(14)],
            [UserIdSequence::class, 12, 13, UserId::fromInt(14)],

            [FixtureNumericSequence::class, 153, 13, 153],
            [ServiceIdSequence::class, 153, 13, ServiceId::fromInt(153)],
            [UserIdSequence::class, 153, 13, UserId::fromInt(153)],
        ];
    }

    /**
     * @template T2
     *
     * @param class-string<Sequence<T2>> $sequenceClassName
     */
    #[DataProvider('provideForceSetCurrentValueForSequenceData')]
    public function testForceSetCurrentValueForSequence(
        string $sequenceClassName,
        mixed $defaultStartValue,
        mixed $forceSetCurrentValue,
        mixed $expectedNext
    ): void {
        /** @var CurrentValueManagement $sequences */
        $sequences = $this->getSequencesUnderTest($defaultStartValue);
        $sequences->forceSetCurrentValueForSequence(
            $sequenceClassName,
            $forceSetCurrentValue
        );

        $sequence = new $sequenceClassName($sequences);

        self::assertInstanceOf($sequenceClassName, $sequence);
        self::assertEquals($expectedNext, $sequence->next());
    }

    public static function provideForceSetCurrentValueForSequenceData(): array
    {
        return [
            [FixtureNumericSequence::class, 3, 1, 2],
            [ServiceIdSequence::class, 3, 1, ServiceId::fromInt(2)],
            [UserIdSequence::class, 3, 1, UserId::fromInt(2)],

            [FixtureNumericSequence::class, 12, 5, 6],
            [ServiceIdSequence::class, 12, 5, ServiceId::fromInt(6)],
            [UserIdSequence::class, 12, 5, UserId::fromInt(6)],

            [FixtureNumericSequence::class, 12, 11, 12],
            [ServiceIdSequence::class, 12, 11, ServiceId::fromInt(12)],
            [UserIdSequence::class, 12, 11, UserId::fromInt(12)],

            [FixtureNumericSequence::class, 12, 12, 13],
            [ServiceIdSequence::class, 12, 12, ServiceId::fromInt(13)],
            [UserIdSequence::class, 12, 12, UserId::fromInt(13)],

            [FixtureNumericSequence::class, 12, 13, 14],
            [ServiceIdSequence::class, 12, 13, ServiceId::fromInt(14)],
            [UserIdSequence::class, 12, 13, UserId::fromInt(14)],

            [FixtureNumericSequence::class, 153, 13, 14],
            [ServiceIdSequence::class, 153, 13, ServiceId::fromInt(14)],
            [UserIdSequence::class, 153, 13, UserId::fromInt(14)],
        ];
    }

    /**
     * @template T2
     *
     * @param class-string<Sequence<T2>> $sequenceClassName
     */
    #[DataProvider('provideGetCurrentValueForSequenceData')]
    public function testGetCurrentValueForSequence(
        string $sequenceClassName,
        mixed $defaultStartValue,
        mixed $forceSetCurrentValue,
        mixed $expectedNext
    ): void {
        // We do this because the default start value is what
        // current should be after the first next() call.
        $expectedStartValue = $defaultStartValue - 1;

        /** @var CurrentValueManagement $sequences */
        $sequences = $this->getSequencesUnderTest($defaultStartValue);

        $currentValueBefore = $sequences->getCurrentValueForSequence($sequenceClassName);

        $sequences->forceSetCurrentValueForSequence(
            $sequenceClassName,
            $forceSetCurrentValue
        );

        $currentValueAfter = $sequences->getCurrentValueForSequence($sequenceClassName);

        $sequence = new $sequenceClassName($sequences);

        self::assertInstanceOf($sequenceClassName, $sequence);
        self::assertEquals($expectedNext, $sequence->next());
        self::assertEquals($expectedStartValue, $currentValueBefore);
        self::assertEquals($forceSetCurrentValue, $currentValueAfter);
    }

    public static function provideGetCurrentValueForSequenceData(): array
    {
        return [
            [FixtureNumericSequence::class, 3, 1, 2],
            [ServiceIdSequence::class, 3, 1, ServiceId::fromInt(2)],
            [UserIdSequence::class, 3, 1, UserId::fromInt(2)],

            [FixtureNumericSequence::class, 12, 5, 6],
            [ServiceIdSequence::class, 12, 5, ServiceId::fromInt(6)],
            [UserIdSequence::class, 12, 5, UserId::fromInt(6)],

            [FixtureNumericSequence::class, 12, 11, 12],
            [ServiceIdSequence::class, 12, 11, ServiceId::fromInt(12)],
            [UserIdSequence::class, 12, 11, UserId::fromInt(12)],

            [FixtureNumericSequence::class, 12, 12, 13],
            [ServiceIdSequence::class, 12, 12, ServiceId::fromInt(13)],
            [UserIdSequence::class, 12, 12, UserId::fromInt(13)],

            [FixtureNumericSequence::class, 12, 13, 14],
            [ServiceIdSequence::class, 12, 13, ServiceId::fromInt(14)],
            [UserIdSequence::class, 12, 13, UserId::fromInt(14)],

            [FixtureNumericSequence::class, 153, 13, 14],
            [ServiceIdSequence::class, 153, 13, ServiceId::fromInt(14)],
            [UserIdSequence::class, 153, 13, UserId::fromInt(14)],
        ];
    }

    /**
     * @template T2
     */
    public function testHasCurrentValueForSequence(): void
    {
        $sequences = $this->getSequencesUnderTest(100);

        $sequence = new FixtureNumericSequence($sequences);

        self::assertFalse($sequences->hasCurrentValueForSequence(FixtureNumericSequence::class));
        self::assertFalse($sequences->hasCurrentValueForSequence(FixtureNumericSequence::class));
        self::assertEquals(99, $sequences->getCurrentValueForSequence(FixtureNumericSequence::class));
        self::assertFalse($sequences->hasCurrentValueForSequence(FixtureNumericSequence::class));
        self::assertEquals(100, $sequence->next());
        self::assertTrue($sequences->hasCurrentValueForSequence(FixtureNumericSequence::class));
        self::assertEquals(100, $sequences->getCurrentValueForSequence(FixtureNumericSequence::class));
    }
}
