<?php

declare(strict_types=1);

namespace Simensen\Sequence\Tests\Unit\Configuration\Adapter\Fixture;

use Simensen\Sequence\Sequence\CurrentValueColumn;
use Simensen\Sequence\Sequence\Sequence;

/**
 * @implements Sequence<FixtureId>
 */
#[CurrentValueColumn('fixture_column_with_column_only')]
class FixtureSequenceWithColumnOnly implements Sequence
{
    use DefaultSequenceFixtureBehavior;
}
