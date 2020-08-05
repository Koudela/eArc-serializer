<?php

namespace eArc\SerializerTests;

class C
{
    protected $classReference;

    public function __construct()
    {
        $this->classReference = new D($this);
    }
}
