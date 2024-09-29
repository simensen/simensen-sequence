<?php

declare(strict_types=1);

namespace Simensen\Sequence\Tests\Unit\Fixture\User;

final readonly class UserId
{
    private function __construct(private int $userId)
    {
    }

    public static function fromInt(int $userId): self
    {
        return new self($userId);
    }

    public function toInt(): int
    {
        return $this->userId;
    }
}
