<?php

declare(strict_types=1);

namespace Simensen\Sequence\Tests\Unit\Configuration\Adapter\Fixture;

use Simensen\Sequence\Sequence\Name;

#[Name('fixture_name_with_inheritance_top')]
class FixtureSequenceWithInheritanceTop extends FixtureSequenceWithInheritanceMiddle
{
}
