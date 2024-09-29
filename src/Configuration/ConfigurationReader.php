<?php

declare(strict_types=1);

namespace Simensen\Sequence\Configuration;

use Simensen\Sequence\Sequence\Sequence;

interface ConfigurationReader
{
    /**
     * @template T
     *
     * @param class-string<Sequence<T>> $sequenceClassName
     */
    public function readSequenceConfigurationForClass(string $sequenceClassName): Configuration;
}
