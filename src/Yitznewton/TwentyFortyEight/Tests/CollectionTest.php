<?php

namespace Yitznewton\TwentyFortyEight\Tests;

use Yitznewton\TwentyFortyEight\Collection;

class CollectionTest extends \PHPUnit_Framework_TestCase
{
    public function testToArray()
    {
        $array = [1,2,3];
        $collection = new Collection($array);
        $this->assertSame($array, $collection->toArray());
    }

    public function testCount()
    {
        $collection = new Collection([1,2,3]);
        $this->assertEquals(3, count($collection));
    }

    public function testAppend()
    {
        $collection = new Collection([1,2,3]);
        $this->assertEquals(new Collection([1,2,3,4]), $collection->append(4));
    }

    public function testSlice()
    {
        $collection = new Collection([1,2,3]);
        $this->assertEquals(new Collection([2,3]), $collection->slice(1));
        $this->assertEquals(new Collection([2]), $collection->slice(1, 1));
    }

    public function testMerge()
    {
        $array0 = new Collection([1,2,3]);
        $array1 = new Collection([4]);
        $this->assertEquals(new Collection([1,2,3,4]), $array0->merge($array1));
    }

    public function testIndex()
    {
        $collection = new Collection([1,2,3]);
        $this->assertEquals(2, $collection->index(1));

        $this->setExpectedException(\OutOfRangeException::class);
        $collection->index(999);
    }

    public function testDelete()
    {
        $collection = new Collection([1,2,3,4,3,5,3,6,3,7]);
        $this->assertEquals(new Collection([1,2,4,5,6,7]), $collection->delete(3));
    }
}
