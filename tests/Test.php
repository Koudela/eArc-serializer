<?php declare(strict_types=1);

namespace eArc\SerializerTests;

use DateTime;
use eArc\DI\DI;
use eArc\Serializer\Api\Serializer;
use eArc\Serializer\SerializerTypes\Interfaces\SerializerTypeInterface;
use eArc\Serializer\SerializerTypes\SerializerNativeType;
use PHPUnit\Framework\TestCase;

/**
 * This is no unit test. It is an integration test.
 */
class Test extends TestCase
{
    public function testNullValue()
    {
        DI::init();

        $value = null;
        $serializedValue = di_get(Serializer::class)->serialize($value, di_get(SerializerNativeType::class));
        $deserializedValue = di_get(Serializer::class)->deserialize($serializedValue, di_get(SerializerNativeType::class));
        self::assertSame($value, $deserializedValue);

        $value = null;
        $serializedValue = di_get(Serializer::class)->serialize($value);
        $deserializedValue = di_get(Serializer::class)->deserialize($serializedValue);
        self::assertSame($value, $deserializedValue);
    }

    public function testBooleanValue()
    {
        DI::init();

        $value = true;
        $serializedValue = di_get(Serializer::class)->serialize($value, di_get(SerializerNativeType::class));
        $deserializedValue = di_get(Serializer::class)->deserialize($serializedValue, di_get(SerializerNativeType::class));
        self::assertSame($value, $deserializedValue);

        $value = false;
        $serializedValue = di_get(Serializer::class)->serialize($value, di_get(SerializerNativeType::class));
        $deserializedValue = di_get(Serializer::class)->deserialize($serializedValue, di_get(SerializerNativeType::class));
        self::assertSame($value, $deserializedValue);

        $value = true;
        $serializedValue = di_get(Serializer::class)->serialize($value);
        $deserializedValue = di_get(Serializer::class)->deserialize($serializedValue);
        self::assertSame($value, $deserializedValue);

        $value = false;
        $serializedValue = di_get(Serializer::class)->serialize($value);
        $deserializedValue = di_get(Serializer::class)->deserialize($serializedValue);
        self::assertSame($value, $deserializedValue);
    }

    public function testIntegerValue()
    {
        DI::init();

        $value = 42;
        $serializedValue = di_get(Serializer::class)->serialize($value, di_get(SerializerNativeType::class));
        $deserializedValue = di_get(Serializer::class)->deserialize($serializedValue, di_get(SerializerNativeType::class));
        self::assertSame($value, $deserializedValue);

        $value = 42;
        $serializedValue = di_get(Serializer::class)->serialize($value);
        $deserializedValue = di_get(Serializer::class)->deserialize($serializedValue);
        self::assertSame($value, $deserializedValue);
    }

    public function testStringValue()
    {
        DI::init();

        $value = 'This is a string.';
        $serializedValue = di_get(Serializer::class)->serialize($value, di_get(SerializerNativeType::class));
        $deserializedValue = di_get(Serializer::class)->deserialize($serializedValue, di_get(SerializerNativeType::class));
        self::assertSame($value, $deserializedValue);

        $value = 'This is a string.';
        $serializedValue = di_get(Serializer::class)->serialize($value);
        $deserializedValue = di_get(Serializer::class)->deserialize($serializedValue);
        self::assertSame($value, $deserializedValue);
    }

    public function testFloatValue()
    {
        DI::init();

        $value = 4.209;
        $serializedValue = di_get(Serializer::class)->serialize($value, di_get(SerializerNativeType::class));
        $deserializedValue = di_get(Serializer::class)->deserialize($serializedValue, di_get(SerializerNativeType::class));
        self::assertSame($value, $deserializedValue);

        $value = 4.209;
        $serializedValue = di_get(Serializer::class)->serialize($value);
        $deserializedValue = di_get(Serializer::class)->deserialize($serializedValue);
        self::assertSame($value, $deserializedValue);
    }

    public function testDateTimeValue()
    {
        DI::init();

        $value = new DateTime();
        $serializedValue = di_get(Serializer::class)->serialize($value, di_get(SerializerNativeType::class));
        $deserializedValue = di_get(Serializer::class)->deserialize($serializedValue, di_get(SerializerNativeType::class));
        self::assertEquals($value, $deserializedValue);

        $value = new DateTime();
        $serializedValue = di_get(Serializer::class)->serialize($value);
        $deserializedValue = di_get(Serializer::class)->deserialize($serializedValue);
        self::assertEquals($value, $deserializedValue);
    }

    public function testArrayValue()
    {
        DI::init();

        $value = [10 => 4.209, 42, 'key' => 'This is a string', ['next level' => [22, 23, 123]], null, new B()];
        $serializedValue = di_get(Serializer::class)->serialize($value, di_get(SerializerNativeType::class));
        $deserializedValue = di_get(Serializer::class)->deserialize($serializedValue, di_get(SerializerNativeType::class));
        self::assertEquals($value, $deserializedValue);

        $value = [10 => 4.209, 42, 'key' => 'This is a string', ['next level' => [22, 23, 123]], null, new B()];
        $serializedValue = di_get(Serializer::class)->serialize($value);
        $deserializedValue = di_get(Serializer::class)->deserialize($serializedValue);
        self::assertEquals($value, $deserializedValue);
    }

    public function testObjectValue()
    {
        DI::init();

        $value = (object) [10 => 4.209, 42, 'key' => 'This is a string', (object) ['next level' => (object) [22, 23, 123]], null, new B()];
        $serializedValue = di_get(Serializer::class)->serialize($value);
        $deserializedValue = di_get(Serializer::class)->deserialize($serializedValue);
        self::assertEquals($value, $deserializedValue);
    }

    public function testClassInstanceValue()
    {
        DI::init();
        $this->processTestClassInstanceValue(di_get(SerializerNativeType::class));
        $this->processTestClassInstanceValue(null);
    }

    public function processTestClassInstanceValue(?SerializerTypeInterface $serializerType): void
    {
        $value = new A();
        $serializedValue = di_get(Serializer::class)->serialize($value, $serializerType);
        $deserializedValue = di_get(Serializer::class)->deserialize($serializedValue, $serializerType);
        self::assertEquals($value, $deserializedValue);

        $value = new B();
        $serializedValue = di_get(Serializer::class)->serialize($value, $serializerType);
        $deserializedValue = di_get(Serializer::class)->deserialize($serializedValue, $serializerType);
        self::assertEquals($value, $deserializedValue);
        self::assertNotEquals(new A(), $deserializedValue);

        $value = new C();
        $serializedValue = di_get(Serializer::class)->serialize($value, $serializerType);
        $deserializedValue = di_get(Serializer::class)->deserialize($serializedValue, $serializerType);
        self::assertEquals($value, $deserializedValue);

        $classE = new E();
        $value = ['a' => $classE, 'b' => $classE];
        $serializedValue = di_get(Serializer::class)->serialize($value, $serializerType);
        $deserializedValue = di_get(Serializer::class)->deserialize($serializedValue, $serializerType);
        self::assertSame($deserializedValue['a'], $deserializedValue['b']);
    }

    public function testSerializerTypeFilter()
    {
        DI::init();

        $value = new A();
        $serializedValue = di_get(Serializer::class)->serialize($value, di_get(TestSerializerType::class));
        $deserializedValue = di_get(Serializer::class)->deserialize($serializedValue, di_get(TestSerializerType::class));
        self::assertEquals($value, $deserializedValue);

        $value = new B();
        $serializedValue = di_get(Serializer::class)->serialize($value, di_get(TestSerializerType::class));
        $deserializedValue = di_get(Serializer::class)->deserialize($serializedValue, di_get(TestSerializerType::class));
        self::assertNotEquals($value, $deserializedValue);
    }
}
