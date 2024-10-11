# Sequence

Sequence is an opinionated model for generating sequences of unique integers.

## Description

This model was designed to extract and make explicit the requirement that some
models need to have auto-incrementing behavior. It originated from a project
that required MySQL-style auto-incrementing fields.

## Installation

Install the project with Composer:

```bash
composer require simensen/sequence
```

## Usage

### `Sequence`

#### The `Sequence<T>` Interface

The `Sequence<T>` interface represents the state of an incrementing numeric
value.

Calling a `Sequence`'s `next(): T` method will return the next value. The core
expectations for the next value:

- The next value SHOULD be a number (`int`)
- The next value SHOULD be unique to the sequence

Additional `Sequences` (see below for `Sequences`) may provide additional
guarantees.

#### Sequence Configuration

Attributes are provided to facilitate commonly needed Sequence configuration
without introducing these concepts through the public interfaces.

##### `Connection`

Used to configure the connection name used by the sequence.

##### `CurrentValueColumn`

Used to configure the column or field name that contains the sequence's
current value.

##### `DefaultStartValue`

Used to configure the start value of a sequence.

##### `Name`

Used to configure the name of the sequence.

##### `NameColumn`

Used to configure the column or field that contains the sequence's name.

##### `Table`

Used to configure the table or document name that contains the sequence.

#### `NumericSequence`

The `NumericSequence` abstract class can be used when a native `int` will
suffice.

```php
use Simensen\Sequence\NumericSequence;

#[Connection('accounting_db')]
#[Table('invoice_number_sequence')]
final readonly class InvoiceNumber extends NumericSequence
{
}
```

#### `CastedSequence`

The `CastedSequence<T>` abstract class can be used when a model wraps the
native `int` with a value object of type `T`. The transformation from `int`
to type `T` is facilitated by a `cast(int $next): T` method.

```php
use Simensen\Sequence\CastedSequence;

/**
 * @extends CastedSequence<PartId>
 */
#[Table('part_id_seq')]
final readonly class PartIdSequence extends CastedSequence
{
    protected function cast(int $next): PartId
    {
        return PartId::fromInt($next);
    }
}
```

### `Sequences`

The `Sequences` interface provides the bridge between a `Sequence` and its
underlying persistence infrastructure.

Calling a `Sequences`' `generateForClass($sequenceClassName): int` method will
return the next value for the specified `$sequenceClassName`. The core
expectations for the next value:

- The `Sequences` MAY require additional configuration
  - The `Sequences` MAY introduce additional Sequence Configuration attributes
- The `Sequences` SHOULD read and map the Sequence Configuration attributes
  where possible
  - An in-memory implementation may not care about `Column`, `Connection`, or
    `Table`
  - A database-backed implementation may care about `Column`, `Connection`, or
    `Table`
- The next value SHOULD be a number (`int`)
- The next value SHOULD be unique to *at least* the sequence

Additional `Sequences` may provide additional guarantees.

#### `GlobalInMemorySequences`

This `Sequences` implementation is useful for testing. It generates unique
next values using the same underlying value for every type of `Sequence<T>`.

```php
use Simensen\Sequence\Sequences\Sequences\GlobalInMemorySequences;

$sequences = new GlobalInMemorySequences();

$userIdSequence = new UserIdSequence($sequences);
$serviceIdSequence = new ServiceIdSequence($sequences);

$userIdSequence->next(); // 1
$userIdSequence->next(); // 2

$serviceIdSequence->next(); // 3

$userIdSequence->next(); // 4
```

#### `ClassBasedInMemorySequences`

This `Sequences` implementation is useful for testing. It generates unique
next values using a different underlying value for every type of
`Sequence<T>`.

```php
use Simensen\Sequence\Sequences\Sequences\ClassBasedInMemorySequences;

$sequences = new ClassBasedInMemorySequences();

$userIdSequence = new UserIdSequence($sequences);
$serviceIdSequence = new ServiceIdSequence($sequences);

$userIdSequence->next(); // 1
$userIdSequence->next(); // 2

$serviceIdSequence->next(); // 1

$userIdSequence->next(); // 3
```

#### `CurrentValueManagement`

The `CurrentValueManagement` interface exposes additional functionality
for `Sequences` to manage aspects of `Sequence`'s current value.

##### `registerPotentialCurrentValueForSequence`

Useful for backfilling sequence-related data. This method sets the current
value to the specified value only if it is a larger value than the
existing current value.

This method is called with a `Sequence<T>` class name and a *potential current
value*.

If the `Sequence<T>` does not have a current value yet, the default start
value is used for the current value.

If the *potential current value* is greater than the current value for the
`Sequence<T>`, the *potential current value* becomes the new current value.

Otherwise, there is no change to the current value.

##### `forceSetCurrentValueForSequence`

Useful in testing. This method sets the current value to the specified value
regardless of the existing current value.

This method is called with a `Sequence<T>` class name and a *value*.

The current value for the `Sequence<T>` is always set to the new value.

## License

This project is licensed under the [MIT License](LICENSE). See the `LICENSE`
file for more details on terms and conditions.

Feel free to use and contribute to the project under these terms!
