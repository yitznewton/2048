<?php

namespace Yitznewton\TwentyFortyEight\Tests;

use Yitznewton\TwentyFortyEight\Grid;

class GridTest extends \PHPUnit_Framework_TestCase
{
    public function testReduce()
    {
        $grid = Grid::fromArray([[1,2],[3,4]]);

        $this->assertTrue($grid->reduce(function ($carry, $item) {
            return $carry || $item > 2;
        }, false));

        $this->assertFalse($grid->reduce(function ($carry, $item) {
            return $carry || $item < 0;
        }, false));
    }

    public function testContains()
    {
        $grid = Grid::fromArray([[1,2],[3,4]]);
        $this->assertTrue($grid->contains(3));
        $this->assertFalse($grid->contains(9));
    }

    public function testCount()
    {
        $grid = Grid::fromArray([[1,2],[3,4]]);
        $this->assertEquals(2, $grid->count());
    }

    public function testReplaceRandomWhereTargetExists()
    {
        $grid = Grid::fromArray([[3,3],[3,3]]);
        $newGrid = $grid->replaceRandom(3, 9);
        $this->assertTrue($newGrid->contains(3));
        $this->assertTrue($newGrid->contains(9));
    }

    public function testReplaceRandomWhereTargetNotExists()
    {
        $grid = Grid::fromArray([[3,3],[3,3]]);
        $newGrid = $grid->replaceRandom(4, 9);
        $this->assertTrue($newGrid->contains(3));
        $this->assertFalse($newGrid->contains(9));
    }

    public function testFromArray()
    {
        $array = [
            [1,2],
            [3,4],
        ];

        $this->assertEquals($array, Grid::fromArray($array)->toArray());
    }

    public function testFromArrayWithNonSquare()
    {
        $this->setExpectedException(\InvalidArgumentException::class);
        Grid::fromArray([1,2]);
    }
}
