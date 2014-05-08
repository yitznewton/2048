<?php

namespace Yitznewton\TwentyFortyEight\Tests;

use Yitznewton\TwentyFortyEight\Board;
use Yitznewton\TwentyFortyEight\Move;

class BoardTest extends \PHPUnit_Framework_TestCase
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

    public function testAddMoveWithEmptyAdjacentCells()
    {
        $initialBoard = $this->getBoard([
            [2,-1],
            [2,-1],
        ]);

        $expected = [
            [2,-1],
            [2,-1],
        ];

        $this->assertEquals($expected, $initialBoard->addMove(Move::LEFT));
    }

    public function testAddMoveEmptiesCollapseFully()
    {
        $initialBoard = $this->getBoard([
            [-1,-1,2],
            [-1,2,2],
            [2,4,8],
        ]);

        $expected = [
            [2,-1,-1],
            [4,-1,-1],
            [2,4,8],
        ];

        $this->assertEquals($expected, $initialBoard->addMove(Move::LEFT));
    }

    /**
     * @dataProvider dataForDifferingAdjacentCells
     * @param array $grid
     * @param array $expected
     * @param mixed $move
     */
    public function testAddMoveWithDifferingAdjacentCells(array $grid, array $expected, $move)
    {
        $initialBoard = $this->getBoard($grid);
        $this->assertEquals($expected, $initialBoard->addMove($move));
    }

    public function testAddShiftIntoEmpty()
    {
        $initialBoard = $this->getBoard([
            [-1,2],
            [2,4],
        ]);

        $expected = [
            [2,-1],
            [2,4],
        ];

        $this->assertEquals($expected, $initialBoard->addMove(Move::LEFT));
    }

    /**
     * @dataProvider dataForMerge
     * @param array $grid
     * @param array $expected
     * @param mixed $move
     */
    public function testAddMoveWithCellsToMerge(array $grid, array $expected, $move)
    {
        $initialBoard = $this->getBoard($grid);
        $this->assertEquals($expected, $initialBoard->addMove($move));
    }

    /**
     * @dataProvider dataForHasPossibleMoves
     * @param array $grid
     * @param bool $expected
     */
    public function testHasPossibleMoves(array $grid, $expected)
    {
        $this->assertSame($expected, $this->getBoard($grid)->hasPossibleMoves());
    }

    private function getBoard($grid)
    {
        return new Board($grid);
    }
}
