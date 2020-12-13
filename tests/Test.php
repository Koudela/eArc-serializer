<?php declare(strict_types=1);

namespace eArc\SerializerTests;

use DateTime;
use eArc\DI\DI;
use eArc\Serializer\DataTypes\ArrayDataType;
use eArc\Serializer\DataTypes\ClassDataType;
use eArc\Serializer\DataTypes\DateTimeDataType;
use eArc\Serializer\DataTypes\ObjectDataType;
use eArc\Serializer\DataTypes\SimpleDataType;
use eArc\Serializer\Api\Interfaces\SerializerInterface;
use eArc\Serializer\Api\Serializer;
use PHPUnit\Framework\TestCase;

/**
 * This is no unit test. It is an integration test.
 */
class Test extends TestCase
{
    public function init()
    {
        DI::init();
        di_tag(DateTimeDataType::class, SerializerInterface::class);
        di_tag(SimpleDataType::class, SerializerInterface::class);
        di_tag(ArrayDataType::class, SerializerInterface::class);
        di_tag(ClassDataType::class, SerializerInterface::class);
        di_tag(ObjectDataType::class, SerializerInterface::class);
    }

    public function testNullValue()
    {
        $this->init();

        $value = null;
        $serializedValue = di_get(Serializer::class)->serialize($value);
        $deserializedValue = di_get(Serializer::class)->deserialize($serializedValue);
        self::assertSame($value, $deserializedValue);
    }

    public function testBooleanValue()
    {
        $this->init();

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
        $this->init();

        $value = 42;
        $serializedValue = di_get(Serializer::class)->serialize($value);
        $deserializedValue = di_get(Serializer::class)->deserialize($serializedValue);
        self::assertSame($value, $deserializedValue);
    }

    public function testStringValue()
    {
        $this->init();

        $value = 'This is a string.';
        $serializedValue = di_get(Serializer::class)->serialize($value);
        $deserializedValue = di_get(Serializer::class)->deserialize($serializedValue);
        self::assertSame($value, $deserializedValue);
    }

    public function testFloatValue()
    {
        $this->init();

        $value = 4.209;
        $serializedValue = di_get(Serializer::class)->serialize($value);
        $deserializedValue = di_get(Serializer::class)->deserialize($serializedValue);
        self::assertSame($value, $deserializedValue);
    }

    public function testDateTimeValue()
    {
        $this->init();

        $value = new DateTime();
        $serializedValue = di_get(Serializer::class)->serialize($value);
        $deserializedValue = di_get(Serializer::class)->deserialize($serializedValue);
        self::assertEquals($value, $deserializedValue);
    }

    public function testArrayValue()
    {
        $this->init();

        $value = [10 => 4.209, 42, 'key' => 'This is a string', ['next level' => [22, 23, 123]], null, new B()];
        $serializedValue = di_get(Serializer::class)->serialize($value);
        $deserializedValue = di_get(Serializer::class)->deserialize($serializedValue);
        self::assertEquals($value, $deserializedValue);
    }

    public function testObjectValue()
    {
        $this->init();

        $value = (object) [10 => 4.209, 42, 'key' => 'This is a string', (object) ['next level' => (object) [22, 23, 123]], null, new B()];
        $serializedValue = di_get(Serializer::class)->serialize($value);
        $deserializedValue = di_get(Serializer::class)->deserialize($serializedValue);
        self::assertEquals($value, $deserializedValue);
    }

    public function testClassInstanceValue()
    {
        $this->init();

        $value = new A();
        $serializedValue = di_get(Serializer::class)->serialize($value);
        $deserializedValue = di_get(Serializer::class)->deserialize($serializedValue);
        self::assertEquals($value, $deserializedValue);

        $value = new B();
        $serializedValue = di_get(Serializer::class)->serialize($value);
        $deserializedValue = di_get(Serializer::class)->deserialize($serializedValue);
        self::assertEquals($value, $deserializedValue);
        self::assertNotEquals(new A(), $deserializedValue);

        $value = new C();
        $serializedValue = di_get(Serializer::class)->serialize($value);
        $deserializedValue = di_get(Serializer::class)->deserialize($serializedValue);
        self::assertEquals($value, $deserializedValue);

        $classE = new E();
        $value = ['a' => $classE, 'b' => $classE];
        $serializedValue = di_get(Serializer::class)->serialize($value);
        $deserializedValue = di_get(Serializer::class)->deserialize($serializedValue);
        self::assertSame($deserializedValue['a'], $deserializedValue['b']);
    }
}
