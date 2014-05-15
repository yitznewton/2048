<?php

namespace Yitznewton\TwentyFortyEight\Tests\Input\Artificial;

use Yitznewton\TwentyFortyEight\Grid;
use Yitznewton\TwentyFortyEight\Input\Artificial\ArtificialInputA;
use Yitznewton\TwentyFortyEight\Move\Move;

class ArtificialInputATest extends \PHPUnit_Framework_TestCase
{
    public function getWithOnePossibleMove()
    {
        return [
            [
                [
                    [2,4],
                    [-1,-1]
                ],
                Move::DOWN,
            ],
            [
                [
                    [-1,4],
                    [-1,2]
                ],
                Move::LEFT,
            ],
        ];
    }

    public function getWithScoringAndOneNonScoring()
    {
        return [
            [
                [
                    [4,4,8],
                    [16,32,8],
                    [-1,-1,-1],
                ],
                [Move::UP, Move::DOWN],
            ],
            [
                [
                    [8,8,4],
                    [16,32,4],
                    [-1,-1,-1],
                ],
                [Move::LEFT, Move::RIGHT],
            ],
        ];
    }

    /**
     * @dataProvider getWithOnePossibleMove
     * @param array $gridArray
     * @param mixed $possibleMove
     */
    public function testWithOnePossibleMove($gridArray, $possibleMove)
    {
        $grid = Grid::fromArray($gridArray);
        $input = new ArtificialInputA($grid);
        $this->assertEquals($possibleMove, $input->getMove());
    }

    /**
     * @dataProvider getWithScoringAndOneNonScoring
     * @param array $gridArray
     * @param array $expectedMoves
     */
    public function testWithScoringAndOneNonScoring($gridArray, $expectedMoves)
    {
        $grid = Grid::fromArray($gridArray);
        $input = new ArtificialInputA($grid);
        $this->assertOneOf($expectedMoves, $input->getMove());
    }

    private function assertOneOf(array $expected, $actual)
    {
        $this->assertTrue(in_array($actual, $expected), sprintf('"%s" is in %s', $actual, print_r($expected, true)));
    }
}
