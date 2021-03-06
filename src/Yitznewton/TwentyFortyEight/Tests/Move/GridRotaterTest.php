<?php

namespace Yitznewton\TwentyFortyEight\Tests\Move;

use Yitznewton\TwentyFortyEight\Grid;
use Yitznewton\TwentyFortyEight\Move\GridRotater;
use Yitznewton\TwentyFortyEight\Move\Move;

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

    public function getGridsForTestRotateForMove()
    {
        return [
            [
                [
                    [1,2,3],
                    [4,5,6],
                    [7,8,9],
                ],
                Move::DOWN,
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
                Move::LEFT,
                [
                    [1,2,3],
                    [4,5,6],
                    [7,8,9],
                ],
            ],
            [
                [
                    [1,2,3],
                    [4,5,6],
                    [7,8,9],
                ],
                Move::RIGHT,
                [
                    [9,8,7],
                    [6,5,4],
                    [3,2,1],
                ],
            ],
            [
                [
                    [1,2,3],
                    [4,5,6],
                    [7,8,9],
                ],
                Move::UP,
                [
                    [3,6,9],
                    [2,5,8],
                    [1,4,7],
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
        $grid = Grid::fromArray($grid);
        $expected = Grid::fromArray($expected);
        $this->assertEquals($expected, (new GridRotater())->rotate($grid, $numberOfRotations));
    }

    /**
     * @dataProvider getGridsForTestRotateForMove
     * @param array $grid
     * @param mixed $move
     * @param array $expected
     */
    public function testRotateForMove($grid, $move, $expected)
    {
        $grid = Grid::fromArray($grid);
        $expected = Grid::fromArray($expected);
        $this->assertEquals($expected, (new GridRotater())->rotateForMove($grid, $move));
    }

    /**
     * @dataProvider getGridsForTestRotateForMove
     * @param array $grid
     * @param mixed $move
     */
    public function testUnrotateForMove($grid, $move)
    {
        $grid = Grid::fromArray($grid);
        $rotater = new GridRotater();
        $rotated = $rotater->rotateForMove($grid, $move);
        $this->assertEquals($grid, $rotater->unrotateForMove($rotated, $move));
    }

    public function testRotateForMoveWithInvalidMove()
    {
        $this->setExpectedException(\UnexpectedValueException::class);
        $grid = Grid::fromArray([[1,2],[3,4]]);
        (new GridRotater())->rotateForMove($grid, 'wut');
    }
}
