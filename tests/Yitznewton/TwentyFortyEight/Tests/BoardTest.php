<?php

namespace Yitznewton\TwentyFortyEight\Tests;

use Yitznewton\TwentyFortyEight\Board;
use Yitznewton\TwentyFortyEight\Move;

class BoardTest extends \PHPUnit_Framework_TestCase
{
    public function testAddMoveGoesNowhere()
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

    public function testAddMoveTwoDifferentCells()
    {
        $initialBoard = new Board([
            [2,4],
            [-1,-1],
        ]);

        $expectedBoard = new Board([
            [2,4],
            [-1,-1],
        ]);

        $this->assertEquals($expectedBoard, $initialBoard->addMove(Move::LEFT));
    }

    public function testAddMoveTwoDifferentUp()
    {
        $initialBoard = new Board([
            [2,2],
            [4,-1],
        ]);

        $expectedBoard = new Board([
            [2,2],
            [4,-1],
        ]);

        $this->assertEquals($expectedBoard, $initialBoard->addMove(Move::UP));
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

    public function testAddMergeTwoByTwo()
    {
        $initialBoard = new Board([
            [2,2],
            [4,-1],
        ]);

        $expectedBoard = new Board([
            [4,-1],
            [4,-1],
        ]);

        $this->assertEquals($expectedBoard, $initialBoard->addMove(Move::LEFT));
    }
}
