<?php

declare(strict_types=1);

namespace Simensen\Sequence\Tests\Unit;

use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Simensen\Sequence\Sequences\Adapter\ClassBasedInMemorySequences;
use Simensen\Sequence\Sequences\Adapter\GlobalInMemorySequences;
use Simensen\Sequence\Tests\Unit\Fixture\Service\ServiceId;
use Simensen\Sequence\Tests\Unit\Fixture\Service\ServiceIdSequence;
use Simensen\Sequence\Tests\Unit\Fixture\User\UserId;
use Simensen\Sequence\Tests\Unit\Fixture\User\UserIdSequence;

class CastedSequenceTest extends TestCase
{
    #[TestDox('Using default GlobalInMemorySequences')]
    public function testUsingDefaultGlobalInMemorySequences(): void
    {
        $sequences = new GlobalInMemorySequences();

        $userIdSequence = new UserIdSequence($sequences);
        $serviceIdSequence = new ServiceIdSequence($sequences);

        // Global sequence should return 1, 2
        $userId = $userIdSequence->next();
        $serviceId = $serviceIdSequence->next();

        self::assertInstanceOf(UserId::class, $userId);
        self::assertSame(1, $userId->toInt());

        self::assertInstanceOf(ServiceId::class, $serviceId);
        self::assertSame(2, $serviceId->toInt());

        // Global sequence should return 3, 4
        // - reversing the order of service and user
        $serviceId = $serviceIdSequence->next();
        $userId = $userIdSequence->next();

        self::assertInstanceOf(ServiceId::class, $serviceId);
        self::assertSame(3, $serviceId->toInt());

        self::assertInstanceOf(UserId::class, $userId);
        self::assertSame(4, $userId->toInt());
    }

    #[TestDox('Using configured GlobalInMemorySequences')]
    public function testUsingConfiguredGlobalInMemorySequences(): void
    {
        $sequences = new GlobalInMemorySequences(5);

        $userIdSequence = new UserIdSequence($sequences);
        $serviceIdSequence = new ServiceIdSequence($sequences);

        // Global sequence should return 5, 6
        $userId = $userIdSequence->next();
        $serviceId = $serviceIdSequence->next();

        self::assertInstanceOf(UserId::class, $userId);
        self::assertSame(5, $userId->toInt());

        self::assertInstanceOf(ServiceId::class, $serviceId);
        self::assertSame(6, $serviceId->toInt());

        // Global sequence should return 7, 8
        // - reversing the order of service and user
        $serviceId = $serviceIdSequence->next();
        $userId = $userIdSequence->next();

        self::assertInstanceOf(ServiceId::class, $serviceId);
        self::assertSame(7, $serviceId->toInt());

        self::assertInstanceOf(UserId::class, $userId);
        self::assertSame(8, $userId->toInt());
    }

    #[TestDox('Using default ClassBasedInMemorySequences')]
    public function testUsingDefaultClassBasedInMemorySequences(): void
    {
        $sequences = new ClassBasedInMemorySequences();

        $userIdSequence = new UserIdSequence($sequences);
        $serviceIdSequence = new ServiceIdSequence($sequences);

        // Class-based should return 1 for both classes
        $userId = $userIdSequence->next();
        $serviceId = $serviceIdSequence->next();

        self::assertInstanceOf(UserId::class, $userId);
        self::assertSame(1, $userId->toInt());

        self::assertInstanceOf(ServiceId::class, $serviceId);
        self::assertSame(1, $serviceId->toInt());

        // Class-based should return 2 for both classes
        // - reversing the order of service and user
        $serviceId = $serviceIdSequence->next();
        $userId = $userIdSequence->next();

        self::assertInstanceOf(ServiceId::class, $serviceId);
        self::assertSame(2, $serviceId->toInt());

        self::assertInstanceOf(UserId::class, $userId);
        self::assertSame(2, $userId->toInt());
    }

    #[TestDox('Using configured ClassBasedInMemorySequences')]
    public function testUsingConfiguredClassBasedInMemorySequences(): void
    {
        $sequences = new ClassBasedInMemorySequences(5);

        $userIdSequence = new UserIdSequence($sequences);
        $serviceIdSequence = new ServiceIdSequence($sequences);

        // Class-based should return 5 for both classes
        $userId = $userIdSequence->next();
        $serviceId = $serviceIdSequence->next();

        self::assertInstanceOf(UserId::class, $userId);
        self::assertSame(5, $userId->toInt());

        self::assertInstanceOf(ServiceId::class, $serviceId);
        self::assertSame(5, $serviceId->toInt());

        // Class-based should return 6 for both classes
        // - reversing the order of service and user
        $serviceId = $serviceIdSequence->next();
        $userId = $userIdSequence->next();

        self::assertInstanceOf(ServiceId::class, $serviceId);
        self::assertSame(6, $serviceId->toInt());

        self::assertInstanceOf(UserId::class, $userId);
        self::assertSame(6, $userId->toInt());
    }

    #[TestDox('Using configured ClassBasedInMemorySequences')]
    public function testUsingConfiguredClassBasedInMemorySequencesNonDefaultForOneClass(): void
    {
        $sequences = new ClassBasedInMemorySequences(setup: [
            ServiceIdSequence::class => ['startValue' => 10],
        ]);

        $userIdSequence = new UserIdSequence($sequences);
        $serviceIdSequence = new ServiceIdSequence($sequences);

        // Class-based configuration should return 1 for UserId but 10 for ServiceId
        $userId = $userIdSequence->next();
        $serviceId = $serviceIdSequence->next();

        self::assertInstanceOf(UserId::class, $userId);
        self::assertSame(1, $userId->toInt());

        self::assertInstanceOf(ServiceId::class, $serviceId);
        self::assertSame(10, $serviceId->toInt());

        // Class-based should return 6 for both classes
        // - reversing the order of service and user
        $serviceId = $serviceIdSequence->next();
        $userId = $userIdSequence->next();

        self::assertInstanceOf(ServiceId::class, $serviceId);
        self::assertSame(11, $serviceId->toInt());

        self::assertInstanceOf(UserId::class, $userId);
        self::assertSame(2, $userId->toInt());
    }

    #[TestDox('Using configured ClassBasedInMemorySequences')]
    public function testUsingConfiguredClassBasedInMemorySequencesNonDefaultForMultipleClasses(): void
    {
        $sequences = new ClassBasedInMemorySequences(setup: [
            UserIdSequence::class => ['startValue' => 80],
            ServiceIdSequence::class => ['startValue' => 75],
        ]);

        $userIdSequence = new UserIdSequence($sequences);
        $serviceIdSequence = new ServiceIdSequence($sequences);

        // Class-based configuration should return 1 for UserId but 10 for ServiceId
        $userId = $userIdSequence->next();
        $serviceId = $serviceIdSequence->next();

        self::assertInstanceOf(UserId::class, $userId);
        self::assertSame(80, $userId->toInt());

        self::assertInstanceOf(ServiceId::class, $serviceId);
        self::assertSame(75, $serviceId->toInt());

        // Class-based should return 6 for both classes
        // - reversing the order of service and user
        $serviceId = $serviceIdSequence->next();
        $userId = $userIdSequence->next();

        self::assertInstanceOf(ServiceId::class, $serviceId);
        self::assertSame(76, $serviceId->toInt());

        self::assertInstanceOf(UserId::class, $userId);
        self::assertSame(81, $userId->toInt());
    }
}
