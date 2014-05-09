<?php

namespace Yitznewton\TwentyFortyEight\Tests;

use Yitznewton\TwentyFortyEight\ArrayObj;

class ArrayObjTest extends \PHPUnit_Framework_TestCase
{
    public function testToArray()
    {
        $array = [1,2,3];
        $arrayObj = new ArrayObj($array);
        $this->assertSame($array, $arrayObj->toArray());
    }

    public function testCount()
    {
        $arrayObj = new ArrayObj([1,2,3]);
        $this->assertEquals(3, $arrayObj->count());
    }

    public function testAppend()
    {
        $arrayObj = new ArrayObj([1,2,3]);
        $this->assertEquals(new ArrayObj([1,2,3,4]), $arrayObj->append(4));
    }

    public function testSlice()
    {
        $arrayObj = new ArrayObj([1,2,3]);
        $this->assertEquals(new ArrayObj([2,3]), $arrayObj->slice(1));
        $this->assertEquals(new ArrayObj([2]), $arrayObj->slice(1, 1));
    }

    public function testMerge()
    {
        $array0 = new ArrayObj([1,2,3]);
        $array1 = new ArrayObj([4]);
        $this->assertEquals(new ArrayObj([1,2,3,4]), $array0->merge($array1));
    }

    public function testIndex()
    {
        $arrayObj = new ArrayObj([1,2,3]);
        $this->assertEquals(2, $arrayObj->index(1));

        $this->setExpectedException(\OutOfRangeException::class);
        $arrayObj->index(999);
    }
}
