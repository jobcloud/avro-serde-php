<?php

declare(strict_types=1);

namespace FlixTech\AvroSerializer\Test\Objects\Schema;

use FlixTech\AvroSerializer\Objects\Schema;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class LogicalTypeTest extends TestCase
{
    #[Test]
    #[DataProvider('provideLogicalTypes')]
    public function it_should_serialize_simple_logical_types(callable $factory, string $expectedAnnotatedType, string $expectedLogicalType): void
    {
        $expectedSchema = [
            'type' => $expectedAnnotatedType,
            'logicalType' => $expectedLogicalType,
        ];

        $this->assertEquals($expectedSchema, $factory()->serialize());
    }

    #[Test]
    #[DataProvider('provideLogicalTypes')]
    public function it_should_parse_simple_logical_types(callable $factory, string $expectedType, string $expectedLogicalType): void
    {
        $parsedSchema = $factory()->parse();
        $this->assertEquals($expectedType, $parsedSchema->type());
        $this->assertEquals($expectedLogicalType, $parsedSchema->logical_type());
    }

    #[Test]
    public function it_should_serialize_duration_types(): void
    {
        $schema = Schema::duration()
            ->name('User')
            ->namespace('org.acme')
            ->aliases('foobar')
            ->serialize();

        $expected = [
            'logicalType' => 'duration',
            'type' => 'fixed',
            'name' => 'User',
            'namespace' => 'org.acme',
            'aliases' => ['foobar'],
            'size' => 12,
        ];

        $this->assertEquals($expected, $schema);
    }

    #[Test]
    public function it_should_parse_duration_types(): void
    {
        $parsedSchema = Schema::duration()
            ->name('User')
            ->namespace('org.acme')
            ->aliases('foobar')
            ->parse();

        $this->assertEquals('fixed', $parsedSchema->type());
        $this->assertEquals('duration', $parsedSchema->logical_type());
    }

    /**
     * @return array<string, array{callable, string, string}>
     */
    public static function provideLogicalTypes(): array
    {
        return [
            'uuid' => [static fn (): Schema => Schema::uuid(), 'string', 'uuid'],
            'date' => [static fn (): Schema => Schema::date(), 'int', 'date'],
            'time-millis' => [static fn (): Schema => Schema::timeMillis(), 'int', 'time-millis'],
            'time-micros' => [static fn (): Schema => Schema::timeMicros(), 'long', 'time-micros'],
            'timestamp-millis' => [static fn (): Schema => Schema::timestampMillis(), 'long', 'timestamp-millis'],
            'timestamp-micros' => [static fn (): Schema => Schema::timestampMicros(), 'long', 'timestamp-micros'],
            'local-timestamp-millis' => [static fn (): Schema => Schema::localTimestampMillis(), 'long', 'local-timestamp-millis'],
            'local-timestamp-micros' => [static fn (): Schema => Schema::localTimestampMicros(), 'long', 'local-timestamp-micros'],
        ];
    }
}
