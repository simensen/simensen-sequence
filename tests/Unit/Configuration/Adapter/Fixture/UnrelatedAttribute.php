<?php

declare(strict_types=1);

namespace Simensen\Sequence\Tests\Unit\Configuration\Adapter\Fixture;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class UnrelatedAttribute
{
    public function __construct(public string $name)
    {
    }
}
