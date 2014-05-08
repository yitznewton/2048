<?php

namespace Yitznewton\TwentyFortyEight\Tests;

use Yitznewton\TwentyFortyEight\GridRotater;

class GridRotaterTest extends \PHPUnit_Framework_TestCase
{
    public function getGridsForTestRotate()
    {
        return [
            [
                [
                    [1,2,3],
                    [4,5,6],
                    [7,8,9],
                ],
                1,
                [
                    [7,4,1],
                    [8,5,2],
                    [9,6,3],
                ],
            ],
            [
                [
                    [1,2,3],
                    [4,5,6],
                    [7,8,9],
                ],
                2,
                [
                    [9,8,7],
                    [6,5,4],
                    [3,2,1],
                ],
            ],
        ];
    }

    /**
     * @dataProvider getGridsForTestRotate
     * @param array $grid
     * @param int $numberOfRotations
     * @param array $expected
     */
    public function testRotate($grid, $numberOfRotations, $expected)
    {
        $this->assertEquals($expected, (new GridRotater())->rotate($grid, $numberOfRotations));
    }
}
