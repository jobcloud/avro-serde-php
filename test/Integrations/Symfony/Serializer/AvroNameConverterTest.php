<?php

declare(strict_types=1);

namespace FlixTech\AvroSerializer\Test\Integrations\Symfony\Serializer;

use Doctrine\Common\Annotations\AnnotationReader as DoctrineAnnotationReader;
use FlixTech\AvroSerializer\Integrations\Symfony\Serializer\AvroSerDeEncoder;
use FlixTech\AvroSerializer\Integrations\Symfony\Serializer\NameConverter\AvroNameConverter;
use FlixTech\AvroSerializer\Objects\Schema\Generation\AnnotationReader;
use FlixTech\AvroSerializer\Test\Integrations\Symfony\Serializer\Fixture\SampleUserRecord;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class AvroNameConverterTest extends TestCase
{
    private AvroNameConverter $nameConverter;

    protected function setUp(): void
    {
        $this->nameConverter = new AvroNameConverter(
            new AnnotationReader(new DoctrineAnnotationReader()),
        );
    }

    #[Test]
    public function it_should_return_the_normalized_property_name(): void
    {
        $normalizedName = $this->nameConverter
            ->normalize('name', SampleUserRecord::class, AvroSerDeEncoder::FORMAT_AVRO);
        $this->assertEquals('Name', $normalizedName);
    }

    #[Test]
    public function it_should_return_the_denormalized_property_name(): void
    {
        $normalizedName = $this->nameConverter
            ->denormalize('Name', SampleUserRecord::class, AvroSerDeEncoder::FORMAT_AVRO);
        $this->assertEquals('name', $normalizedName);
    }

    #[Test]
    public function it_should_return_the_property_name_unchanged_without_class_or_avro_format(): void
    {
        $this->assertSame('name', $this->nameConverter->normalize('name'));
        $this->assertSame('name', $this->nameConverter->normalize('name', 'UnknownClass', AvroSerDeEncoder::FORMAT_AVRO));
        $this->assertSame('name', $this->nameConverter->normalize('name', SampleUserRecord::class, 'json'));
    }

    #[Test]
    public function it_should_cache_the_name_map_and_keep_properties_without_avro_name(): void
    {
        $this->assertSame('Name', $this->nameConverter->normalize('name', SampleUserRecord::class, AvroSerDeEncoder::FORMAT_AVRO));
        $this->assertSame('Name', $this->nameConverter->normalize('name', SampleUserRecord::class, AvroSerDeEncoder::FORMAT_AVRO));
        $this->assertSame('other', $this->nameConverter->normalize('other', SampleUserRecord::class, AvroSerDeEncoder::FORMAT_AVRO));
    }
}
