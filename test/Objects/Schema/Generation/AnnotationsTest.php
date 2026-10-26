<?php

declare(strict_types=1);

namespace FlixTech\AvroSerializer\Test\Objects\Schema\Generation;

use FlixTech\AvroSerializer\Objects\Schema\AttributeName;
use FlixTech\AvroSerializer\Objects\Schema\Generation\Annotations as SerDe;
use FlixTech\AvroSerializer\Objects\Schema\Generation\SchemaAttribute;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class AnnotationsTest extends TestCase
{
    #[Test]
    #[DataProvider('provideAnnotations')]
    public function it_should_expose_name_value_and_empty_attributes(
        string $class,
        mixed $value,
        string $expectedName,
    ): void {
        /** @var SchemaAttribute $annotation */
        $annotation = new $class();
        $annotation->value = $value;

        $this->assertSame($expectedName, $annotation->name());
        $this->assertSame($value, $annotation->value());
        $this->assertCount(0, $annotation->attributes());
    }

    /**
     * @return array<string, array{class-string, mixed, string}>
     */
    public static function provideAnnotations(): array
    {
        return [
            'aliases' => [SerDe\AvroAliases::class, ['a', 'b'], AttributeName::ALIASES],
            'default' => [SerDe\AvroDefault::class, 42, AttributeName::DEFAULT],
            'doc' => [SerDe\AvroDoc::class, 'doc', AttributeName::DOC],
            'name' => [SerDe\AvroName::class, 'name', AttributeName::NAME],
            'namespace' => [SerDe\AvroNamespace::class, 'org.acme', AttributeName::NAMESPACE],
            'order' => [SerDe\AvroOrder::class, 'ascending', AttributeName::ORDER],
            'size' => [SerDe\AvroSize::class, 16, AttributeName::SIZE],
            'symbols' => [SerDe\AvroSymbols::class, ['A', 'B'], AttributeName::SYMBOLS],
            'target-class' => [SerDe\AvroTargetClass::class, 'Foo', AttributeName::TARGET_CLASS],
        ];
    }
}
