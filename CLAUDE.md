# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Development Commands

This project uses a Makefile for development tasks:

- `make test` - Run PHPUnit tests
- `make test-coverage` - Run tests with coverage (requires Xdebug)
- `make cs` - Fix code style with PHP CS Fixer, normalize composer.json, lint YAML and Markdown
- `make phpstan` - Run static analysis with PHPStan at max level
- `make phive` - Install development tools via PHIVE
- `make vendor` - Install Composer dependencies
- `make clean` - Remove vendor and tools directories
- `make help` - Show available targets

Direct tool commands (after running `make phive`):
- `phpunit` - Run tests directly
- `phpstan analyse` - Run static analysis
- `php-cs-fixer fix` - Fix code style

## Architecture Overview

This is a PHP library for generating sequences of unique integers with configurable persistence backends.

### Core Components

**Sequence Interface (`Sequence<T>`)**: The main abstraction representing an incrementing numeric value. The `next(): T` method returns the next value in the sequence.

**Sequences Interface**: Provides the bridge between a `Sequence` and its underlying persistence infrastructure via `nextValueForSequence(string $sequenceClassName): int`.

**Abstract Implementations**:
- `NumericSequence` - For sequences that return native `int` values
- `CastedSequence<T>` - For sequences that wrap `int` in value objects via a `cast(int $next): T` method

### Configuration System

Sequences are configured using PHP attributes that are read by `ClassTraitConfigurationReader`:
- `#[Connection]` - Database connection name
- `#[Table]` - Table/document name for storage
- `#[Name]` - Sequence name
- `#[NameColumn]` - Column containing sequence name
- `#[CurrentValueColumn]` - Column containing current value
- `#[DefaultStartValue]` - Initial sequence value

Configuration reading supports inheritance - attributes from parent classes and traits are merged.

### Built-in Sequences Implementations

**In-Memory Implementations** (primarily for testing):
- `GlobalInMemorySequences` - Single counter shared across all sequence types
- `ClassBasedInMemorySequences` - Separate counter per sequence class

**Current Value Management**: Additional interface for managing sequence state, with methods like `registerPotentialCurrentValueForSequence()` for backfilling and `forceSetCurrentValueForSequence()` for testing.

## Code Patterns

- Uses PHP 8+ features including attributes, readonly classes, and generic types
- Follows PSR-4 autoloading with `Simensen\Sequence` namespace
- Test fixtures are in `tests/Unit/*/Fixture/` directories
- Configuration attributes support inheritance through traits and parent classes
- All classes use `declare(strict_types=1)`