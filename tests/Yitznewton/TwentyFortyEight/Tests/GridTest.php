<?php

namespace Yitznewton\TwentyFortyEight\Tests;

use Yitznewton\TwentyFortyEight\Grid;

class GridTest extends \PHPUnit_Framework_TestCase
{
    public function testReduce()
    {
        $grid = Grid::createFilled(2, 3);

        $this->assertTrue($grid->reduce(function ($carry, $item) {
            return $carry || $item > 2;
        }, false));

        $this->assertFalse($grid->reduce(function ($carry, $item) {
            return $carry || $item < 0;
        }, false));
    }

    public function testContains()
    {
        $grid = Grid::createFilled(2, 3);
        $this->assertTrue($grid->contains(3));
    }

    public function testReplaceRandomWhereTargetExists()
    {
        $grid = Grid::createFilled(2, 3);
        $newGrid = $grid->replaceRandom(3, 9);
        $this->assertTrue($newGrid->contains(3));
        $this->assertTrue($newGrid->contains(9));
    }

    public function testReplaceRandomWhereTargetNotExists()
    {
        $grid = Grid::createFilled(2, 3);
        $newGrid = $grid->replaceRandom(4, 9);
        $this->assertTrue($newGrid->contains(3));
        $this->assertFalse($newGrid->contains(9));
    }

    public function testCreateAndAccess()
    {
        $expected = [
            ['test', 'test'],
            ['test', 'test'],
        ];
        $this->assertEquals($expected, Grid::createFilled(2, 'test')->toArray());
    }
}
