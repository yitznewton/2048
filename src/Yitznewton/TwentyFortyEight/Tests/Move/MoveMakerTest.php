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
     * @dataProvider dataForImpossibleMove
     * @param array $grid
     * @param mixed $move
     */
    public function testMakeMoveWithImpossibleMove(array $grid, $move)
    {
        $calculator = $this->getCalculator($grid);
        $this->setExpectedException(ImpossibleMoveException::class);
        $calculator->makeMove($move);
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

    public function testMergeListener()
    {
        $grid = [
            [3,3],
            [-1,-1],
        ];
        $listener = new StackListener();
        $this->getCalculator($grid, $listener)->makeMove(Move::LEFT);

        $expected = [['addCollapseEvent', [3,3]]];
        $this->assertEquals($expected, $listener->getEvents());
    }

    private function getCalculator($grid, MoveListener $listener = null)
    {
        $calculator = new MoveMaker(Grid::fromArray($grid));

        if ($listener) {
            $calculator->addListener($listener);
        }

        return $calculator;
    }
}
