<?php

declare(strict_types=1);

namespace Simensen\Sequence\Tests\Unit\Configuration\Adapter;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use Simensen\Sequence\Configuration\Adapter\ClassTraitConfigurationReader;
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
use Simensen\Sequence\Tests\Unit\Configuration\Adapter\Fixture\FixtureSequenceWithInheritanceTop;
use Simensen\Sequence\Tests\Unit\Configuration\Adapter\Fixture\FixtureSequenceWithNoAttributes;
use Simensen\Sequence\Tests\Unit\Configuration\Adapter\Fixture\FixtureSequenceWithTableAndUnrelated;
use Simensen\Sequence\Tests\Unit\Configuration\Adapter\Fixture\FixtureSequenceWithTableOnly;

class ClassTraitConfigurationReaderTest extends TestCase
{
    #[TestDox('$sequenceClassName deep')]
    public function testDeep(): void
    {
        $configurationReader = new ClassTraitConfigurationReader();

        $configuration = $configurationReader->readSequenceConfigurationForClass(
            FixtureSequenceWithInheritanceTop::class
        );

        self::assertEquals(
            'fixture_connection_with_inheritance_bottom',
            $configuration->getConnectionName()
        );

        self::assertEquals(
            'fixture_table_with_inheritance_middle',
            $configuration->getTableName()
        );

        self::assertEquals(
            'fixture_name_with_inheritance_top',
            $configuration->getName()
        );
    }

    #[TestDox('$sequenceClassName')]
    #[DataProvider('provideData')]
    public function test(string $sequenceClassName, Configuration $expectedConfiguration): void
    {
        $configurationReader = new ClassTraitConfigurationReader();

        $actualConfiguration = $configurationReader->readSequenceConfigurationForClass($sequenceClassName);

        self::assertEquals($expectedConfiguration, $actualConfiguration);
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
            [FixtureSequenceWithNoAttributes::class, new Configuration(
                FixtureSequenceWithNoAttributes::class
            )],
            [FixtureSequenceWithAllAttributes::class, new Configuration(
                FixtureSequenceWithAllAttributes::class,
                currentValueColumn: new CurrentValueColumn('fixture_column_with_all_attributes'),
                connection: new Connection('fixture_connection_with_all_attributes'),
                table: new Table('fixture_table_with_all_attributes')
            )],
            [FixtureSequenceWithColumnOnly::class, new Configuration(
                FixtureSequenceWithColumnOnly::class,
                currentValueColumn: new CurrentValueColumn('fixture_column_with_column_only')
            )],
            [FixtureSequenceWithConnectionOnly::class, new Configuration(
                FixtureSequenceWithConnectionOnly::class,
                connection: new Connection('fixture_connection_with_connection_only')
            )],
            [FixtureSequenceWithTableOnly::class, new Configuration(
                FixtureSequenceWithTableOnly::class,
                table: new Table('fixture_table_with_table_only')
            )],
            [FixtureSequenceWithColumnAndConnection::class, new Configuration(
                FixtureSequenceWithColumnAndConnection::class,
                currentValueColumn: new CurrentValueColumn('fixture_column_with_column_and_connection'),
                connection: new Connection('fixture_connection_with_column_and_connection')
            )],
            [FixtureSequenceWithColumnAndTable::class, new Configuration(
                FixtureSequenceWithColumnAndTable::class,
                currentValueColumn: new CurrentValueColumn('fixture_column_with_column_and_table'),
                table: new Table('fixture_table_with_column_and_table')
            )],
            [FixtureSequenceWithConnectionAndTable::class, new Configuration(
                FixtureSequenceWithConnectionAndTable::class,
                connection: new Connection('fixture_connection_with_connection_and_table'),
                table: new Table('fixture_table_with_connection_and_table')
            )],
            [FixtureSequenceWithTableAndUnrelated::class, new Configuration(
                FixtureSequenceWithTableAndUnrelated::class,
                table: new Table('fixture_table_with_table_and_unrelated')
            )],
        ];
    }
}
