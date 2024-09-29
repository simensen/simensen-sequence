<?php

declare(strict_types=1);

namespace Simensen\Sequence\Tests\Unit\Fixture\User;

use Simensen\Sequence\CastedSequence;

/**
 * @extends CastedSequence<UserId>
 */
class UserIdSequence extends CastedSequence
{
    protected function cast(int $next): UserId
    {
        return UserId::fromInt($next);
    }
}
