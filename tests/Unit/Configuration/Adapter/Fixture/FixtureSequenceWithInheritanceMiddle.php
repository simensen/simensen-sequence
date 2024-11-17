<?php

declare(strict_types=1);

namespace Simensen\Sequence\Tests\Unit\Configuration\Adapter\Fixture;

use Simensen\Sequence\Sequence\Name;
use Simensen\Sequence\Sequence\Table;

#[Table('fixture_table_with_inheritance_middle')]
#[Name('fixture_name_with_inheritance_middle')]
class FixtureSequenceWithInheritanceMiddle extends FixtureSequenceWithInheritanceBottom
{
}
