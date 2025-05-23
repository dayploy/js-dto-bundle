<?php

namespace Dayploy\JsDtoBundle\Tests\Generator;

use Dayploy\JsDtoBundle\Generator\Generator;
use Dayploy\JsDtoBundle\Generator\TypeConverter;
use Dayploy\JsDtoBundle\Tests\AbstractTestCase;
use Symfony\Component\TypeInfo\Type\BuiltinType;
use Symfony\Component\TypeInfo\Type\CollectionType;
use Symfony\Component\TypeInfo\Type\GenericType;
use Symfony\Component\TypeInfo\Type\ObjectType;
use Symfony\Component\TypeInfo\Type\UnionType;
use Symfony\Component\TypeInfo\TypeIdentifier;
use Symfony\Component\TypeInfo\Type\NullableType;

class TypeConverterTest extends AbstractTestCase
{
    public function testGenerate(): void
    {
        $container = self::getContainer();

        /** @var Generator */
        $service = $container->get(TypeConverter::class);

        $arrayType = new BuiltinType(TypeIdentifier::ARRAY);
        $generic = new GenericType($arrayType);
        $type = new CollectionType(
            type: $generic,
        );
        $converted = $service->convertType($type);
        $this->assertSame('[]', $converted);

        $intType = new BuiltinType(TypeIdentifier::INT);
        $stringType = new BuiltinType(TypeIdentifier::STRING);

        $generic = new GenericType(
            $arrayType,
            $intType,
            $stringType,
        );
        $type = new CollectionType(
            type: $generic,
            isList: true,
        );
        $converted = $service->convertType($type);
        $this->assertSame('string[]', $converted);

        $entityType = new ObjectType(
            'Some\Path\To\Class',
        );
        $unionType = new UnionType(
            $entityType,
            $stringType,
        );

        $generic = new GenericType(
            $arrayType,
            $intType,
            $unionType,
        );
        $type = new CollectionType(
            type: $generic,
            isList: true,
        );
        $converted = $service->convertType($type);
        $this->assertSame('Class | string[]', $converted);

        $nullType = new NullableType($stringType);
        $convertedNullable = $service->convertType($nullType);
        $this->assertSame('string | null', $convertedNullable);
    }
}
