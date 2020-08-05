<?php  declare(strict_types=1);

namespace eArc\SerializerTests;

class D
{
    protected $injectedReferenceC;

    public function __construct(C $c)
    {
        $this->injectedReferenceC = $c;
    }
}
