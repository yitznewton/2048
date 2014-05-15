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

    public function getComplex()
    {
        return [
            [
                // prefer up over down
                [
                    [256,512,8],
                    [16,32,8],
                    [2,64,128],
                ],
                Move::UP,
            ],
            [
                // prefer left over right
                [
                    [32,8,8],
                    [16,4,64],
                    [2,256,128],
                ],
                Move::LEFT,
            ],
            [
                // think ahead one move for higher score
                [
                    [-1,16,128],
                    [16,2,64],
                    [32,8,8],
                ],
                Move::UP,
            ],
//            [
//                // avoid gaps when predicting
//                [
//                    [4,512,2],
//                    [-1,-1,-1],
//                    [2,-1,2],
//                ],
//                Move::UP,
//            ],
        ];
    }

    /**
     * @dataProvider getWithOnePossibleMove
     * @param array $gridArray
     * @param mixed $possibleMove
     */
    public function testWithOnePossibleMove($gridArray, $possibleMove)
    {
        $input = new ArtificialInputA();
        $grid = Grid::fromArray($gridArray);
        $this->assertEquals($possibleMove, $input->getMove($grid));
    }

    /**
     * @dataProvider getComplex
     * @param array $gridArray
     * @param mixed $expected
     */
    public function testWithScoringAndOneNonScoring($gridArray, $expected)
    {
        $input = new ArtificialInputA();
        $grid = Grid::fromArray($gridArray);
        $this->assertEquals($expected, $input->getMove($grid));
    }
}
