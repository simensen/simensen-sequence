<?php

declare(strict_types=1);

namespace Simensen\Sequence\Configuration\Adapter;

use Simensen\Sequence\Configuration\Behavior\ReadsConfigurationFromTraitsBehavior;
use Simensen\Sequence\Configuration\ConfigurationReader;

final readonly class ClassTraitConfigurationReader implements ConfigurationReader
{
    use ReadsConfigurationFromTraitsBehavior;
}
