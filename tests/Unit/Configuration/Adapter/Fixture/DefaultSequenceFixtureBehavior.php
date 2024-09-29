<?php

declare(strict_types=1);

namespace Simensen\Sequence\Tests\Unit\Configuration\Adapter\Fixture;

use Exception;

trait DefaultSequenceFixtureBehavior
{
    public function next(): mixed
    {
        throw new Exception('Method not expected to be called');
    }
}
