<?php

declare(strict_types=1);

namespace Simensen\Sequence\Tests\Unit\Configuration\Adapter\Fixture;

use Simensen\Sequence\Sequence\Column;
use Simensen\Sequence\Sequence\Sequence;

/**
 * @implements Sequence<FixtureId>
 */
#[Column('fixture_column_with_column_only')]
class FixtureSequenceWithColumnOnly implements Sequence
{
    use DefaultSequenceFixtureBehavior;
}
