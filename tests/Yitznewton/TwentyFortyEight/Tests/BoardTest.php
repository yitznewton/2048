<?php

namespace Yitznewton\TwentyFortyEight\Tests;

use Yitznewton\TwentyFortyEight\Board;
use Yitznewton\TwentyFortyEight\Move;

class BoardTest extends \PHPUnit_Framework_TestCase
{
    public function getForDifferingAdjacentCells()
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

    public function getForMerge()
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

    public function testAddMoveWithEmptyAdjacentCells()
    {
        $initialBoard = new Board([
            [2,-1],
            [2,-1],
        ]);

        $expectedBoard = new Board([
            [2,-1],
            [2,-1],
        ]);

        $this->assertEquals($expectedBoard, $initialBoard->addMove(Move::LEFT));
    }

    public function testAddMoveEmptiesCollapseFully()
    {
        $initialBoard = new Board([
            [-1,-1,2],
            [-1,2,2],
            [2,4,8],
        ]);

        $expectedBoard = new Board([
            [2,-1,-1],
            [4,-1,-1],
            [2,4,8],
        ]);

        $this->assertEquals($expectedBoard, $initialBoard->addMove(Move::LEFT));
    }

    /**
     * @dataProvider getForDifferingAdjacentCells
     * @param array $grid
     * @param array $expected
     * @param mixed $move
     */
    public function testAddMoveWithDifferingAdjacentCells(array $grid, array $expected, $move)
    {
        $initialBoard = new Board($grid);
        $this->assertEquals($expected, $initialBoard->addMove($move)->getGrid());
    }

    public function testAddShiftIntoEmpty()
    {
        $initialBoard = new Board([
            [-1,2],
            [2,4],
        ]);

        $expectedBoard = new Board([
            [2,-1],
            [2,4],
        ]);

        $this->assertEquals($expectedBoard, $initialBoard->addMove(Move::LEFT));
    }

    /**
     * @dataProvider getForMerge
     * @param array $grid
     * @param array $expected
     * @param mixed $move
     */
    public function testAddMoveWithCellsToMerge(array $grid, array $expected, $move)
    {
        $initialBoard = new Board($grid);
        $this->assertEquals($expected, $initialBoard->addMove($move)->getGrid());
    }
}
