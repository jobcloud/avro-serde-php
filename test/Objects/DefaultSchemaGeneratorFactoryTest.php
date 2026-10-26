<?php

declare(strict_types=1);

namespace FlixTech\AvroSerializer\Test\Objects;

use FlixTech\AvroSerializer\Objects\DefaultSchemaGeneratorFactory;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class DefaultSchemaGeneratorFactoryTest extends TestCase
{
    #[Test]
    public function it_should_produce_a_new_SchemaGenerator_on_each_call(): void
    {
        $this->assertNotSame(
            DefaultSchemaGeneratorFactory::get(),
            DefaultSchemaGeneratorFactory::get(),
        );
    }
}
