# earc/serializer

Standalone lightweight extendable serializer component of the eArc libraries.

## table of contents
 
 - [installation](#installation)
 - [basic usage](#basic-usage)
 - [advanced usage](#advanced-usage)
 - [releases](#releases)
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

Then register the data types to the serializer.

```php
use eArc\Serializer\DataTypes\ArrayDataType;
use eArc\Serializer\DataTypes\ClassDataType;
use eArc\Serializer\DataTypes\DateTimeDataType;
use eArc\Serializer\DataTypes\ObjectDataType;
use eArc\Serializer\DataTypes\SimpleDataType;
use eArc\Serializer\Api\Interfaces\SerializerInterface;

di_tag(DateTimeDataType::class, SerializerInterface::class);
di_tag(SimpleDataType::class, SerializerInterface::class);
di_tag(ArrayDataType::class, SerializerInterface::class);
di_tag(ClassDataType::class, SerializerInterface::class);
di_tag(ObjectDataType::class, SerializerInterface::class);
```

Note the order of tagging. If multiple DataTypes are applicable, the DataType 
registered first is applied. 

Now your ready to serialize some content.

```php
use eArc\Serializer\Api\Serializer;

$serializedValue = di_get(Serializer::class)->serialize($value);
$deserializedValue = di_get(Serializer::class)->deserialize($serializedValue);
```

`$value` is the same as `$deserializedValue`.

Not only the data type `object` is supported. Also `DateTime`, `array`, `string`, `int`, 
`float`, `bool` and `null` values. 

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

The serializer can be extended by your own data types. Implement the 
`DataTypeInterface`.

```php
use eArc\Serializer\DataTypes\Interfaces\DataTypeInterface;

class YourDataType implements DataTypeInterface
{
    public function isResponsibleForSerialization(?object $object, $propertyName, $propertyValue): bool
    {
        return is_subclass_of($propertyValue, YourInterface::class);
    }

    public function serialize(?object $object, $propertyName, $propertyValue)
    {
        return [
            'type' => YourInterface::class,
            'value' => 'Put your serialized Information here.',
        ];
    }
    public function isResponsibleForDeserialization(?object $object, string $type, $value): bool
    {
        return $type === YourInterface::class;
    }

    public function deserialize(?object $object, string $type, $value)
    {
        return 'Here you return your deserialized class instance';
    }
}
```

You can use the `FactoryService`, `SerializeService` or the `ObjectHashService`
for specialized tasks.

Don't forget to tag your `YourDataType` class as `SerializerInterface` before
usage.

```php
use eArc\Serializer\Api\Interfaces\SerializerInterface;

di_tag(YourDataType::class, SerializerInterface::class);
```

## releases

### release v0.2
not released yet
- added serialize structures:
    - csv
- data type can be prioritized

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
- serializing structures:
    - json
- personalized data types
- easy readable serialized output
- support for serialization of recursive object relations
