<?php

declare(strict_types=1);

namespace Simensen\Sequence\Tests\Unit\Configuration\Adapter\Fixture;

use Simensen\Sequence\Sequence\Connection;
use Simensen\Sequence\Sequence\Name;
use Simensen\Sequence\Sequence\Sequence;
use Simensen\Sequence\Sequence\Table;

/**
 * @implements Sequence<FixtureId>
 */
#[Connection('fixture_connection_with_inheritance_bottom')]
#[Table('fixture_table_with_inheritance_bottom')]
#[Name('fixture_name_with_inheritance_bottom')]
class FixtureSequenceWithInheritanceBottom implements Sequence
{
    use DefaultSequenceFixtureBehavior;
}
