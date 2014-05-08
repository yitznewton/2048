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

    public function testAddMoveTwoSameValues()
    {
        $initialBoard = new Board([
            [2,2],
            [-1,-1],
        ]);

        $expectedBoard = new Board([
            [4,-1],
            [-1,-1],
        ]);

        $this->assertEquals($expectedBoard, $initialBoard->addMove(Move::LEFT));
    }
}
