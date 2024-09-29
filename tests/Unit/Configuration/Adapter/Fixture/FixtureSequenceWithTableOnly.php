<?php

declare(strict_types=1);

namespace Simensen\Sequence\Tests\Unit\Configuration\Adapter\Fixture;

use Simensen\Sequence\Sequence\Sequence;
use Simensen\Sequence\Sequence\Table;

/**
 * @implements Sequence<FixtureId>
 */
#[Table('fixture_table_with_table_only')]
class FixtureSequenceWithTableOnly implements Sequence
{
    use DefaultSequenceFixtureBehavior;
}
