<?php

declare(strict_types=1);

namespace Simensen\Sequence\Tests\Unit\Configuration\Adapter\Fixture;

use Simensen\Sequence\Sequence\Column;
use Simensen\Sequence\Sequence\Sequence;
use Simensen\Sequence\Sequence\Table;

/**
 * @implements Sequence<FixtureId>
 */
#[Column('fixture_column_with_column_and_table')]
#[Table('fixture_table_with_column_and_table')]
class FixtureSequenceWithColumnAndTable implements Sequence
{
    use DefaultSequenceFixtureBehavior;
}