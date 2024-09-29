<?php

declare(strict_types=1);

namespace Simensen\Sequence\Tests\Unit\Configuration\Adapter\Fixture;

use Simensen\Sequence\Sequence\Sequence;

/**
 * @implements Sequence<FixtureId>
 */
class FixtureSequenceWithNoAttributes implements Sequence
{
    use DefaultSequenceFixtureBehavior;
}
