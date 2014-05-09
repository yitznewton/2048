<?php

namespace Yitznewton\TwentyFortyEight;

class CellInjectorTest extends \PHPUnit_Framework_TestCase
{
    public function dataForTestInjectInto()
    {
        return [
            [
                [
                    [],
                ],
                0,
            ],
            [
                [
                    [2,2],
                    [2,2],
                ],
                4,
            ],
            [
                [
                    [2,2],
                    [2,-1],
                ],
                4,
            ],
            [
                [
                    [-1,-1],
                    [-1,-1],
                ],
                1,
            ],
        ];
    }

    /**
     * @dataProvider dataForTestInjectInto
     * @param array $startingGrid
     * @param int $expectedCellCount
     */
    public function testInjectInto(array $startingGrid, $expectedCellCount)
    {
        $injector = new CellInjector();
        $this->assertFilledCellCount($expectedCellCount, $injector->injectInto($startingGrid));
    }

    private function assertFilledCellCount($expectedCount, array $grid)
    {
        $count = 0;

        for ($i = 0; $i < count($grid); $i++) {
            $row = $grid[$i];
            for ($j = 0; $j < count($row); $j++) {
                if ($row[$j] != MoveCalculator::EMPTY_CELL) {
                    $count++;
                }
            }
        }

        $this->assertEquals($expectedCount, $count);
    }
}
