<?php

declare(strict_types=1);

namespace Simensen\Sequence\Tests\Unit\Sequence;

use PHPUnit\Framework\TestCase;
use Simensen\Sequence\Sequence\Connection;

class ConnectionTest extends TestCase
{
    public function testToString(): void
    {
        $connection = new Connection('test_connection');
        self::assertSame('test_connection', $connection->toString());
    }

    public function testStringify(): void
    {
        $connection = new Connection('test_connection');
        self::assertSame('test_connection', (string) $connection);
    }
}
