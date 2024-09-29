<?php

declare(strict_types=1);

namespace Simensen\Sequence\Tests\Unit\Configuration\Adapter\Fixture;

use Simensen\Sequence\Sequence\Connection;
use Simensen\Sequence\Sequence\Sequence;
use Simensen\Sequence\Sequence\Table;

/**
 * @implements Sequence<FixtureId>
 */
#[Connection('fixture_connection_with_connection_and_table')]
#[Table('fixture_table_with_connection_and_table')]
class FixtureSequenceWithConnectionAndTable implements Sequence
{
    use DefaultSequenceFixtureBehavior;
}
