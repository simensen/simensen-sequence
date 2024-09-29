<?php

declare(strict_types=1);

namespace Simensen\Sequence\Tests\Unit\Fixture\Service;

use Simensen\Sequence\CastedSequence;

/**
 * @extends CastedSequence<ServiceId>
 */
class ServiceIdSequence extends CastedSequence
{
    protected function cast(int $next): ServiceId
    {
        return ServiceId::fromInt($next);
    }
}
