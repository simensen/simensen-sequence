<?php

declare(strict_types=1);

namespace Simensen\Sequence\Tests\Unit\Sequence;

use PHPUnit\Framework\TestCase;
use Simensen\Sequence\Sequence\Table;

class TableTest extends TestCase
{
    public function testToString(): void
    {
        $table = new Table('test_table');
        self::assertSame('test_table', $table->toString());
    }

    public function testStringify(): void
    {
        $table = new Table('test_table');
        self::assertSame('test_table', (string) $table);
    }
}
