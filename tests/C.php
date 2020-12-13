<?php

namespace eArc\SerializerTests;

class C
{
    protected D $classReference;

    public function __construct()
    {
        $this->classReference = new D($this);
    }
}
