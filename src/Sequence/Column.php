<?php

declare(strict_types=1);

namespace Simensen\Sequence\Sequence;

use Attribute;
use Stringable;

#[Attribute(Attribute::TARGET_CLASS)]
final readonly class Column implements Stringable
{
    public function __construct(private string $name)
    {
    }

    public function toString(): string
    {
        return $this->name;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
