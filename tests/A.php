<?php
/** @noinspection PhpUnusedPrivateFieldInspection */
declare(strict_types=1);
/**
 * e-Arc Framework - the explicit Architecture Framework
 *
 * @package earc/serializer
 * @link https://github.com/Koudela/eArc-serializer/
 * @copyright Copyright (c) 2020-2021 Thomas Koudela
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace eArc\SerializerTests;

use DateTime;

class A
{
    public $null1 = null;
    protected $null2 = null;
    private $null3 = null;

    public $bool1 = true;
    protected $bool2 = false;
    private $bool3 = true;

    public $int1 = 1;
    protected $int2 = 2;
    private $int3 = 3;

    public $string1 = '1';
    protected $string2 = '2';
    private $string3 = '3';

    public $float1 = 0.1;
    protected $float2 = 0.2;
    private $float3 = 0.3;

    public $datetime1;
    protected $datetime2;
    private $datetime3;

    public $array1 = [0 => true];
    protected $array2 = ['key' => 4.5];
    private $array3 = ['nested' => [42 => ['even deeper']]];

    var $dynamic;

    public function __construct()
    {
        $this->dynamic = 'very dynamic';
        $this->datetime1 = new DateTime();
        $this->datetime2 = new DateTime();
        $this->datetime3 = new DateTime();
    }
}
