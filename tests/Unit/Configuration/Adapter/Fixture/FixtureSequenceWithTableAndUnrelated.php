<?php

declare(strict_types=1);

namespace Simensen\Sequence\Tests\Unit\Configuration\Adapter\Fixture;

use Simensen\Sequence\Sequence\Sequence;
use Simensen\Sequence\Sequence\Table;

/**
 * @implements Sequence<FixtureId>
 */
#[UnrelatedAttribute('should_not_interfere_with_sequence')]
#[Table('fixture_table_with_table_and_unrelated')]
class FixtureSequenceWithTableAndUnrelated implements Sequence
{
    use DefaultSequenceFixtureBehavior;
}
