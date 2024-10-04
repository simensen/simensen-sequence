<?php

declare(strict_types=1);

namespace Simensen\Sequence\Tests\Unit\Sequence;

use PHPUnit\Framework\TestCase;
use Simensen\Sequence\Sequence\CurrentValueColumn;

class ColumnTest extends TestCase
{
    public function testToString(): void
    {
        $column = new CurrentValueColumn('test_column');
        self::assertSame('test_column', $column->toString());
    }

    public function testStringify(): void
    {
        $column = new CurrentValueColumn('test_column');
        self::assertSame('test_column', (string) $column);
    }
}
