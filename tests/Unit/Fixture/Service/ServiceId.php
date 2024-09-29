<?php

declare(strict_types=1);

namespace Simensen\Sequence\Tests\Unit\Fixture\Service;

final readonly class ServiceId
{
    private function __construct(private int $serviceId)
    {
    }

    public static function fromInt(int $serviceId): self
    {
        return new self($serviceId);
    }

    public function toInt(): int
    {
        return $this->serviceId;
    }
}
