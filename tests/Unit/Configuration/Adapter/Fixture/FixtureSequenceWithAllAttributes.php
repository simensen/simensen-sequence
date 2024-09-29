<?php

declare(strict_types=1);

namespace Simensen\Sequence\Tests\Unit\Configuration\Adapter\Fixture;

use Simensen\Sequence\Sequence\Column;
use Simensen\Sequence\Sequence\Connection;
use Simensen\Sequence\Sequence\Sequence;
use Simensen\Sequence\Sequence\Table;

/**
 * @implements Sequence<FixtureId>
 */
#[Column('fixture_column_with_all_attributes')]
#[Connection('fixture_connection_with_all_attributes')]
#[Table('fixture_table_with_all_attributes')]
class FixtureSequenceWithAllAttributes implements Sequence
{
    use DefaultSequenceFixtureBehavior;
}
