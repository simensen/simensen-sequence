<?php

declare(strict_types=1);

namespace Simensen\Sequence\Tests\Unit\Configuration;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Simensen\Sequence\Configuration\Configuration;
use Simensen\Sequence\Sequence\Connection;
use Simensen\Sequence\Sequence\CurrentValueColumn;
use Simensen\Sequence\Sequence\Table;
use Simensen\Sequence\Tests\Unit\Configuration\Adapter\Fixture\FixtureSequenceWithAllAttributes;
use Simensen\Sequence\Tests\Unit\Configuration\Adapter\Fixture\FixtureSequenceWithColumnAndConnection;
use Simensen\Sequence\Tests\Unit\Configuration\Adapter\Fixture\FixtureSequenceWithColumnAndTable;
use Simensen\Sequence\Tests\Unit\Configuration\Adapter\Fixture\FixtureSequenceWithColumnOnly;
use Simensen\Sequence\Tests\Unit\Configuration\Adapter\Fixture\FixtureSequenceWithConnectionAndTable;
use Simensen\Sequence\Tests\Unit\Configuration\Adapter\Fixture\FixtureSequenceWithConnectionOnly;
use Simensen\Sequence\Tests\Unit\Configuration\Adapter\Fixture\FixtureSequenceWithNoAttributes;
use Simensen\Sequence\Tests\Unit\Configuration\Adapter\Fixture\FixtureSequenceWithTableAndUnrelated;
use Simensen\Sequence\Tests\Unit\Configuration\Adapter\Fixture\FixtureSequenceWithTableOnly;

class ConfigurationTest extends TestCase
{
    #[TestDox('default values')]
    public function testDefaultValues(): void
    {
        $configuration = new Configuration(FixtureSequenceWithNoAttributes::class);

        self::assertSame(FixtureSequenceWithNoAttributes::class, $configuration->getSequenceClassName());

        self::assertNull($configuration->getConnectionName());
        self::assertNull($configuration->getCurrentValueColumnName());
        self::assertNull($configuration->getDefaultStartValue());
        self::assertNull($configuration->getName());
        self::assertNull($configuration->getNameColumnName());
        self::assertNull($configuration->getTableName());

        self::assertSame('test', $configuration->getConnectionName('test'));
        self::assertSame('test', $configuration->getCurrentValueColumnName('test'));
        self::assertSame(5, $configuration->getDefaultStartValue(5));
        self::assertSame('test', $configuration->getName('test'));
        self::assertSame('test', $configuration->getNameColumnName('test'));
        self::assertSame('test', $configuration->getTableName('test'));

        self::assertNull($configuration->getConnectionName());
        self::assertNull($configuration->getCurrentValueColumnName());
        self::assertNull($configuration->getDefaultStartValue());
        self::assertNull($configuration->getName());
        self::assertNull($configuration->getNameColumnName());
        self::assertNull($configuration->getTableName());
    }

    #[TestDox('$sequenceClassName')]
    #[DataProvider('provideData')]
    public function testSequenceClassName(
        Configuration $configuration,
        string $sequenceClassName,
        ?string $currentValueColumnName = null,
        ?string $connectionName = null,
        ?string $tableName = null
    ): void {
        self::assertSame($sequenceClassName, $configuration->getSequenceClassName());
        self::assertSame($currentValueColumnName, $configuration->getCurrentValueColumnName());
        self::assertSame($connectionName, $configuration->getConnectionName());
        self::assertSame($tableName, $configuration->getTableName());

        $blankConfiguration = new Configuration($sequenceClassName);

        self::assertSame($sequenceClassName, $blankConfiguration->getSequenceClassName());
        self::assertNull($blankConfiguration->getConnectionName());
        self::assertNull($blankConfiguration->getCurrentValueColumnName());
        self::assertNull($blankConfiguration->getDefaultStartValue());
        self::assertNull($blankConfiguration->getName());
        self::assertNull($blankConfiguration->getNameColumnName());
        self::assertNull($blankConfiguration->getTableName());

        $defaults = [];

        if ($currentValueColumnName) {
            $defaults['currentValueColumn'] = new CurrentValueColumn($currentValueColumnName);
        }

        if ($connectionName) {
            $defaults['connection'] = new Connection($connectionName);
        }

        if ($tableName) {
            $defaults['table'] = new Table($tableName);
        }

        $withDefaultConfiguration = $blankConfiguration->withDefaults(...$defaults);

        self::assertSame($sequenceClassName, $withDefaultConfiguration->getSequenceClassName());
        self::assertSame($currentValueColumnName, $withDefaultConfiguration->getCurrentValueColumnName());
        self::assertSame($connectionName, $withDefaultConfiguration->getConnectionName());
        self::assertSame($tableName, $withDefaultConfiguration->getTableName());
    }

    public static function provideData(): array
    {
        //                                  Column      Connection  Table
        // [X] WithNone                     -           -           -
        // [X] WithAll                      O           O           O
        // [X] WithColumnOnly               O           -           -
        // [X] WithConnectionOnly           -           O           -
        // [X] WithTableOnly                -           -           O
        // [X] WithColumnAndConnection      O           O           -
        // [X] WithColumnAndTable           O           -           O
        // [X] WithConnectionAndTable       -           O           O
        //

        return [
            [
                'configuration' => new Configuration(
                    FixtureSequenceWithNoAttributes::class
                ),
                'sequenceClassName' => FixtureSequenceWithNoAttributes::class,
            ],
            [
                'configuration' => new Configuration(
                    FixtureSequenceWithAllAttributes::class,
                    currentValueColumn: new CurrentValueColumn('fixture_column_with_all_attributes'),
                    connection: new Connection('fixture_connection_with_all_attributes'),
                    table: new Table('fixture_table_with_all_attributes')
                ),
                'sequenceClassName' => FixtureSequenceWithAllAttributes::class,
                'currentValueColumnName' => 'fixture_column_with_all_attributes',
                'connectionName' => 'fixture_connection_with_all_attributes',
                'tableName' => 'fixture_table_with_all_attributes',
            ],
            [
                'configuration' => new Configuration(
                    FixtureSequenceWithColumnOnly::class,
                    currentValueColumn: new CurrentValueColumn('fixture_column_with_column_only')
                ),
                'sequenceClassName' => FixtureSequenceWithColumnOnly::class,
                'currentValueColumnName' => 'fixture_column_with_column_only',
            ],
            [
                'configuration' => new Configuration(
                    FixtureSequenceWithConnectionOnly::class,
                    connection: new Connection('fixture_connection_with_connection_only')
                ),
                'sequenceClassName' => FixtureSequenceWithConnectionOnly::class,
                'connectionName' => 'fixture_connection_with_connection_only',
            ],
            [
                'configuration' => new Configuration(
                    FixtureSequenceWithTableOnly::class,
                    table: new Table('fixture_table_with_table_only')
                ),
                'sequenceClassName' => FixtureSequenceWithTableOnly::class,
                'tableName' => 'fixture_table_with_table_only',
            ],
            [
                'configuration' => new Configuration(
                    FixtureSequenceWithColumnAndConnection::class,
                    currentValueColumn: new CurrentValueColumn('fixture_column_with_column_and_connection'),
                    connection: new Connection('fixture_connection_with_column_and_connection')
                ),
                'sequenceClassName' => FixtureSequenceWithColumnAndConnection::class,
                'currentValueColumnName' => 'fixture_column_with_column_and_connection',
                'connectionName' => 'fixture_connection_with_column_and_connection',
            ],
            [
                'configuration' => new Configuration(
                    FixtureSequenceWithColumnAndTable::class,
                    currentValueColumn: new CurrentValueColumn('fixture_column_with_column_and_table'),
                    table: new Table('fixture_table_with_column_and_table')
                ),
                'sequenceClassName' => FixtureSequenceWithColumnAndTable::class,
                'currentValueColumnName' => 'fixture_column_with_column_and_table',
                'tableName' => 'fixture_table_with_column_and_table',
            ],
            [
                'configuration' => new Configuration(
                    FixtureSequenceWithConnectionAndTable::class,
                    connection: new Connection('fixture_connection_with_connection_and_table'),
                    table: new Table('fixture_table_with_connection_and_table')
                ),
                'sequenceClassName' => FixtureSequenceWithConnectionAndTable::class,
                'connectionName' => 'fixture_connection_with_connection_and_table',
                'tableName' => 'fixture_table_with_connection_and_table',
            ],
            [
                'configuration' => new Configuration(
                    FixtureSequenceWithTableAndUnrelated::class,
                    table: new Table('fixture_table_with_table_and_unrelated')
                ),
                'sequenceClassName' => FixtureSequenceWithTableAndUnrelated::class,
                'tableName' => 'fixture_table_with_table_and_unrelated',
            ],
        ];
    }
}
