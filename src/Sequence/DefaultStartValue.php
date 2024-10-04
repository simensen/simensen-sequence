<?php

declare(strict_types=1);

namespace Simensen\Sequence\Sequence;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
final readonly class DefaultStartValue
{
    public function __construct(private int $value)
    {
    }

    public function toInt(): int
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }
}
