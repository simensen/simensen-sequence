<?php

declare(strict_types=1);

namespace Simensen\Sequence\Tests\Unit\Configuration\Adapter\Fixture;

use Simensen\Sequence\Sequence\Connection;
use Simensen\Sequence\Sequence\Sequence;

/**
 * @implements Sequence<FixtureId>
 */
#[Connection('fixture_connection_with_connection_only')]
class FixtureSequenceWithConnectionOnly implements Sequence
{
    use DefaultSequenceFixtureBehavior;
}
