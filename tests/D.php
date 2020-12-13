<?php  declare(strict_types=1);

namespace eArc\SerializerTests;

class D
{
    protected C $injectedReferenceC;

    public function __construct(C $c)
    {
        $this->injectedReferenceC = $c;
    }
}
