# earc/serializer

Standalone lightweight extendable serializer component of the eArc libraries.

## table of contents
 
 - [installation](#installation)
 - [basic usage](#basic-usage)
 - [advanced usage](#advanced-usage)
   - [filtering properties](#filtering-properties)
   - [customizing serialization via specialized data types](#customizing-serialization-via-specialized-data-types)
 - [releases](#releases)
   - [release v1.0](#release-v10)
   - [release v0.1](#release-v01)
   - [release v0.0](#release-v00)

## installation

Install the earc serializer library via composer.

```
$ composer require earc/serializer
```

## basic usage

First enable the [earc/di](https://github.com/Koudela/eArc-di/) dependency injection component.

```php
use eArc\DI\DI;

DI::init();
```

Now your ready to serialize some content.

```php
use eArc\Serializer\Api\Serializer;

$serializedValue = di_get(Serializer::class)->serialize($value);
$deserializedValue = di_get(Serializer::class)->deserialize($serializedValue);
```

`$value` is the same as `$deserializedValue`.

The data types `DateTime`, `object`, `array`, `string`, `int`,`float`, `bool` 
and `null` values are supported by the default serialization type out of the box. 

Even serialization of recursive object structures are possible.

```php
use eArc\Serializer\Api\Serializer;

class X {
    /** @var Y */
    protected $referenceToY;

    public function __construct()
    {
        $this->referenceToY = new Y($this);
    }
}

class Y {
    /** @var X */
    protected $referenceToX;

    public function __construct(X $x)
    {
        $this->referenceToX = $x;
    }    
}

$serializedValue = di_get(Serializer::class)->serialize(new X());

echo $serializedValue;
```

This outputs:

`{"type":"X","value":{"content":{"referenceToY":{"type":"Y","value":{"content":{"referenceToX":{"type":"X","value":{"content":null,"id":57}}},"id":60}}},"id":57}}`

```php
$object = di_get(Serializer::class)->deserialize($serializedValue);
```

`$object` yields an instance of `X` referencing an instance of `Y` having a 
reference on `X`. Of course, it is not the same instance as serialized. It's an 
identical instance like you would receive on cloning the object. If multiple 
references point to the same instance, this holds also true after
deserialization. You can enforce same instances by wrapping multiple objects 
into an array.

```php
use eArc\Serializer\Api\Serializer;

class Z1 {}
class Z2 {
    public $z1;
}

$classZ1 = new Z1();
$classZ2 = new Z2();
$classZ2->z1 = $classZ1;

$serializedValue = di_get(Serializer::class)->serialize([0 => $classZ1, 1 => $classZ2]);
```

The deserialized value would also hold two references to the same instance of 
the class `Z1`.

## advanced usage  

The basic usage of the earc/serializer is not superior to the native php 
`serialize/unserialize` function. You should use the earc/serializer only if you 
need the advanced features.

### filtering properties

The earc/serializer offers an easy way to organize the filtering of properties.
Extend the `SerializerDefaultType` and overwrite the `filterProperty()` method.
Only if this method returns true the property will be serialized.

```php
use eArc\Serializer\SerializerTypes\SerializerDefaultType;

class MySerializerType extends SerializerDefaultType
{
    public function filterProperty(string $fQCN, string $propertyName): bool
    {
        static $blacklistProperties = [
            MyClass::class => [
                'myPropertyOne' => true,
                'anotherNotSerializedProperty' => true,
            ],
        ];

        return !array_key_exists($fQCN, $blacklistProperties) 
            && !array_key_exists($propertyName, $blacklistProperties[$fQCN]);
    }
}
```

To use this Filter use an object of the extending class as second argument.

```php
use eArc\Serializer\Api\Serializer;

$serializerType = di_get(MySerializerType::class);

$serializedValue = di_get(Serializer::class)->serialize($value, $serializerType);
$deserializedValue = di_get(Serializer::class)->deserialize($serializedValue, $serializerType);
```

### customizing serialization via specialized data types

There are use cases where you need full control over the serialization process.
For example in the case of further processing the serialized value or if your
object/data needs a special processing prior serialization or post deserialization. 
Specialized data types offer you this level of control while keeping your 
architecture clean.

To create your own data type implement the `DataTypeInterface`.

```php
use eArc\Serializer\DataTypes\Interfaces\DataTypeInterface;

class MyDataType implements DataTypeInterface
{
    public function isResponsibleForSerialization(?object $object, $propertyName, $propertyValue): bool
    {
        return is_subclass_of($propertyValue, MyObjectsClassOrInterface::class);
    }

    public function serialize(?object $object, $propertyName, $propertyValue)
    {
        return [
            'type' => MyObjectsClassOrInterface::class,
            'value' => 'Put your serialized Information here.',
        ];
    }
    public function isResponsibleForDeserialization(?object $object, string $type, $value): bool
    {
        return $type === MyObjectsClassOrInterface::class;
    }

    public function deserialize(?object $object, string $type, $value)
    {
        return 'Here you return your deserialized class instance';
    }
}
```

Hint 1: `serialize()` can return anything that can be processed by the native php
function `json_encode()`. If it is not an array or does not have the `type` and
`value` keys the `$type` parameter will be an empty string and the `$value` 
parameter will hold the serialized value.

Hint 2: You can use the `FactoryService`, `SerializeService` or the `ObjectHashService`
for specialized tasks.

To use the new data type you need a serializer type referencing the new data type.
Either implement the `SerializerTypeInterface` or extend the `SerializerDefaultType`
and overwrite the `getDataTypes()` method.

```php
use eArc\Serializer\SerializerTypes\SerializerDefaultType;

class MySerializerType extends SerializerDefaultType
{
    public function getDataTypes(): iterable
    {
        yield MyDataType::class => null;
        
        foreach (parent::getDataTypes() as $class => $object) {
            yield $class => $object;
        }
    }
}
```

Note the order. If multiple data types are applicable, the data type placed first 
is applied.

Hint: If you need to build the `MyDataType` object by another dependency injection
system than earc/di you can pass the object instead of `null`.

To use the new serializer type instead of the default pass its object as second 
argument to the serializer methods.

```php
use eArc\Serializer\Api\Serializer;

$serializerType = di_get(MySerializerType::class);

$serializedValue = di_get(Serializer::class)->serialize($value, $serializerType);
$deserializedValue = di_get(Serializer::class)->deserialize($serializedValue, $serializerType);
```

Hint: You can use your own dependency injection function (or container) to build 
the serializer type object.

## releases

### release v1.0

- data types can be prioritized
- serializer types passed as parameter instead of tagged data types
- filter (whitelist or blacklist) properties

### release v0.1

- PHP 7.4
- additional supported data types:
    - DateTime
- serialization of private properties of parents

### release v0.0

first official release

- supported data types:
    - object (class instance)
    - object (StdClass)
    - array
    - string
    - float
    - int
    - bool
    - `null`
- customized data types
- support for serialization of recursive object relations
- easy readable serialized output
- serializing structures:
  - json
