<?php

namespace Yitznewton\TwentyFortyEight\Tests;

use Yitznewton\TwentyFortyEight\Grid;
use Yitznewton\TwentyFortyEight\Move;
use Yitznewton\TwentyFortyEight\MoveCalculator;

/**
 * @SuppressWarnings(PHPMD.TooManyMethods)
 */
class MoveCalculatorTest extends \PHPUnit_Framework_TestCase
{
    public function dataForDifferingAdjacentCells()
    {
        return [
            [
                [
                    [2,4],
                    [-1,-1],
                ],
                [
                    [2,4],
                    [-1,-1],
                ],
                Move::LEFT,
            ],
            [
                [
                    [2,2],
                    [4,-1],
                ],
                [
                    [2,2],
                    [4,-1],
                ],
                Move::UP,
            ],
            [
                [
                    [2,4],
                    [-1,4],
                ],
                [
                    [2,4],
                    [-1,4],
                ],
                Move::RIGHT,
            ],
            [
                [
                    [-1,2],
                    [2,4],
                ],
                [
                    [-1,2],
                    [2,4],
                ],
                Move::DOWN,
            ],
        ];
    }

    public function dataForMerge()
    {
        return [
            [
                [
                    [2,2,16],
                    [4,-1,-1],
                    [2,4,8],
                ],
                [
                    [4,16,-1],
                    [4,-1,-1],
                    [2,4,8],
                ],
                Move::LEFT,
            ],
            [
                [
                    [4,4,32,32],
                    [-1,-1,-1,-1],
                    [-1,-1,-1,-1],
                    [-1,-1,-1,-1],
                ],
                [
                    [8,64,-1,-1],
                    [-1,-1,-1,-1],
                    [-1,-1,-1,-1],
                    [-1,-1,-1,-1],
                ],
                Move::LEFT,
            ],
            [
                [
                    [16,2,-1,2],
                    [-1,-1,-1,-1],
                    [-1,-1,-1,-1],
                    [-1,-1,-1,-1],
                ],
                [
                    [16,4,-1,-1],
                    [-1,-1,-1,-1],
                    [-1,-1,-1,-1],
                    [-1,-1,-1,-1],
                ],
                Move::LEFT,
            ],
            [
                [
                    [2,2],
                    [2,4],
                ],
                [
                    [-1,2],
                    [4,4],
                ],
                Move::DOWN,
            ],
        ];
    }

    public function dataForHasPossibleMoves()
    {
        return [
            [
                [
                    [2,4,8],
                    [-1,16,32],
                    [64,128,256],
                ],
                true,
            ],
            [
                [
                    [2,-1,8],
                    [4,16,32],
                    [64,128,256],
                ],
                true,
            ],
            [
                [
                    [2,32,8],
                    [4,16,-1],
                    [64,128,256],
                ],
                true,
            ],
            [
                [
                    [2,32,8],
                    [4,16,128],
                    [64,-1,256],
                ],
                true,
            ],
            [
                [
                    [2,32,8],
                    [16,16,128],
                    [64,512,256],
                ],
                true,
            ],
            [
                [
                    [2,32,8],
                    [4,16,128],
                    [64,16,256],
                ],
                true,
            ],
            [
                [
                    [2,4,8],
                    [512,16,32],
                    [64,128,256],
                ],
                false,
            ],
        ];
    }

    public function dataForIsPossibleMove()
    {
        return [
            [
                [],
                Move::LEFT,
                false,
            ],
            [
                [
                    [2,-1],
                    [2,4],
                ],
                Move::LEFT,
                false,
            ],
            [
                [
                    [-1,2],
                    [2,4],
                ],
                Move::LEFT,
                true,
            ],
        ];
    }

    public function testMakeMoveWithEmptyAdjacentCells()
    {
        $calculator = $this->getCalculator([
            [2,-1],
            [2,-1],
        ]);

        $expected = Grid::fromArray([
            [2,-1],
            [2,-1],
        ]);

        $this->assertEquals($expected, $calculator->makeMove(Move::LEFT));
    }

    public function testMakeMoveEmptiesCollapseFully()
    {
        $calculator = $this->getCalculator([
            [-1,-1,2],
            [-1,2,2],
            [2,4,8],
        ]);

        $expected = Grid::fromArray([
            [2,-1,-1],
            [4,-1,-1],
            [2,4,8],
        ]);

        $this->assertEquals($expected, $calculator->makeMove(Move::LEFT));
    }

    /**
     * @dataProvider dataForDifferingAdjacentCells
     * @param array $grid
     * @param array $expected
     * @param mixed $move
     */
    public function testMakeMoveWithDifferingAdjacentCells(array $grid, array $expected, $move)
    {
        $calculator = $this->getCalculator($grid);
        $this->assertEquals(Grid::fromArray($expected), $calculator->makeMove($move));
    }

    public function testMakeMoveShiftIntoEmpty()
    {
        $calculator = $this->getCalculator([
            [-1,2],
            [2,4],
        ]);

        $expected = Grid::fromArray([
            [2,-1],
            [2,4],
        ]);

        $this->assertEquals($expected, $calculator->makeMove(Move::LEFT));
    }

    /**
     * @dataProvider dataForMerge
     * @param array $grid
     * @param array $expected
     * @param mixed $move
     */
    public function testMakeMoveWithCellsToMerge(array $grid, array $expected, $move)
    {
        $calculator = $this->getCalculator($grid);
        $this->assertEquals(Grid::fromArray($expected), $calculator->makeMove($move));
    }

    /**
     * @dataProvider dataForHasPossibleMoves
     * @param array $grid
     * @param bool $expected
     */
    public function testHasPossibleMoves(array $grid, $expected)
    {
        $this->assertSame($expected, $this->getCalculator($grid)->hasPossibleMoves());
    }

    /**
     * @dataProvider dataForIsPossibleMove
     * @param array $grid
     * @param mixed $move
     * @param bool $expected
     */
    public function testIsPossibleMove(array $grid, $move, $expected)
    {
        $this->assertSame($expected, $this->getCalculator($grid)->isPossibleMove($move));
    }

    private function getCalculator($grid)
    {
        return new MoveCalculator(Grid::fromArray($grid));
    }
}
