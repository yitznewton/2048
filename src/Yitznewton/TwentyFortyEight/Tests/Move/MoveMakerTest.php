<?php

namespace Yitznewton\TwentyFortyEight\Tests\Move;

use Yitznewton\TwentyFortyEight\Grid;
use Yitznewton\TwentyFortyEight\Move\ImpossibleMoveException;
use Yitznewton\TwentyFortyEight\Move\Move;
use Yitznewton\TwentyFortyEight\Move\MoveMaker;
use Yitznewton\TwentyFortyEight\Move\MoveListener;
use Yitznewton\TwentyFortyEight\Tests\Doubles\Move\StackListener;

/**
 * @SuppressWarnings(PHPMD.TooManyMethods)
 */
class MoveMakerTest extends \PHPUnit_Framework_TestCase
{
    public function dataForImpossibleMove()
    {
        return [
            [
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
                Move::UP,
            ],
            [
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
                Move::DOWN,
            ],
            [
                [
                    [2,-1],
                    [2,-1],
                ],
                Move::LEFT,
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
                    [16,32,256],
                    [64,128,-1],
                ],
                true,
            ],
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

    public function dataForGetPossibleMoves()
    {
        return [
            [
                [
                    [2,4,8],
                    [16,32,256],
                    [64,128,-1],
                ],
                [Move::DOWN, Move::RIGHT],
            ],
            [
                [
                    [2,4,8],
                    [-1,16,32],
                    [64,128,256],
                ],
                [Move::UP, Move::DOWN, Move::LEFT],
            ],
            [
                [
                    [2,-1,8],
                    [4,16,32],
                    [64,128,256],
                ],
                [Move::UP, Move::LEFT, Move::RIGHT],
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
            [
                [
                    [-1,2],
                    [2,4],
                ],
                Move::RIGHT,
                false,
            ],
        ];
    }

    public function testMakeMoveEmptiesCollapseFully()
    {
        $moveMaker = $this->getMoveMaker([
            [-1,-1,2],
            [-1,2,2],
            [2,4,8],
        ]);

        $expected = Grid::fromArray([
            [2,-1,-1],
            [4,-1,-1],
            [2,4,8],
        ]);

        $this->assertEquals($expected, $moveMaker->makeMove(Move::LEFT));
    }

    /**
     * @dataProvider dataForImpossibleMove
     * @param array $grid
     * @param mixed $move
     */
    public function testMakeMoveWithImpossibleMove(array $grid, $move)
    {
        $moveMaker = $this->getMoveMaker($grid);
        $this->setExpectedException(ImpossibleMoveException::class);
        $moveMaker->makeMove($move);
    }

    public function testMakeMoveShiftIntoEmpty()
    {
        $moveMaker = $this->getMoveMaker([
            [-1,2],
            [2,4],
        ]);

        $expected = Grid::fromArray([
            [2,-1],
            [2,4],
        ]);

        $this->assertEquals($expected, $moveMaker->makeMove(Move::LEFT));
    }

    /**
     * @dataProvider dataForMerge
     * @param array $grid
     * @param array $expected
     * @param mixed $move
     */
    public function testMakeMoveWithCellsToMerge(array $grid, array $expected, $move)
    {
        $moveMaker = $this->getMoveMaker($grid);
        $this->assertEquals(Grid::fromArray($expected), $moveMaker->makeMove($move));
    }

    /**
     * @dataProvider dataForHasPossibleMoves
     * @param array $grid
     * @param bool $expected
     */
    public function testHasPossibleMoves(array $grid, $expected)
    {
        $this->assertSame($expected, $this->getMoveMaker($grid)->hasPossibleMoves());
    }

    /**
     * @dataProvider dataForGetPossibleMoves
     * @param array $grid
     * @param array $possibleMoves
     */
    public function testGetPossibleMoves(array $grid, array $possibleMoves)
    {
        $this->assertEquals($possibleMoves, $this->getMoveMaker($grid)->getPossibleMoves());
    }

    public function testMergeListener()
    {
        $grid = [
            [3,3],
            [-1,-1],
        ];
        $listener = new StackListener();
        $this->getMoveMaker($grid, $listener)->makeMove(Move::LEFT);

        $expected = [['addCollapseEvent', [3,3]]];
        $this->assertEquals($expected, $listener->getEvents());
    }

    private function getMoveMaker($grid, MoveListener $listener = null)
    {
        $moveMaker = new MoveMaker(Grid::fromArray($grid));

        if ($listener) {
            $moveMaker->addListener($listener);
        }

        return $moveMaker;
    }
}
