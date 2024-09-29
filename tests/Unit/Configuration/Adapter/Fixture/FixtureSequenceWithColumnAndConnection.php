<?php

declare(strict_types=1);

namespace Simensen\Sequence\Tests\Unit\Configuration\Adapter\Fixture;

use Simensen\Sequence\Sequence\Column;
use Simensen\Sequence\Sequence\Connection;
use Simensen\Sequence\Sequence\Sequence;

/**
 * @implements Sequence<FixtureId>
 */
#[Column('fixture_column_with_column_and_connection')]
#[Connection('fixture_connection_with_column_and_connection')]
class FixtureSequenceWithColumnAndConnection implements Sequence
{
    use DefaultSequenceFixtureBehavior;
}
