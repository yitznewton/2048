<?php

namespace Yitznewton\TwentyFortyEight\Tests;

use Yitznewton\TwentyFortyEight\Move;
use Yitznewton\TwentyFortyEight\Scorer;

class ScorerTest extends \PHPUnit_Framework_TestCase
{
    public function dataForGetScore()
    {
        return [
            [
                [
                    [],
                ],
                Move::LEFT,
                0
            ],
            [
                [
                    [2],
                ],
                Move::LEFT,
                0
            ],
            [
                [
                    [2,4],
                ],
                Move::LEFT,
                0
            ],
            [
                [
                    [2,2],
                ],
                Move::LEFT,
                4
            ],
            [
                [
                    [2,4],
                    [2,8],
                ],
                Move::UP,
                4
            ],
            [
                [
                    [4,4,2,2],
                    [4,4,2,2],
                ],
                Move::LEFT,
                24
            ],
        ];
    }

    /**
     * @dataProvider dataForGetScore
     * @param array $startingGrid
     * @param mixed $move
     * @param int $expected
     */
    public function testGetScore($startingGrid, $move, $expected)
    {
        $move;  // PHPMD
        $this->assertSame($expected, (new Scorer())->forMove($startingGrid, $move));
    }
}
