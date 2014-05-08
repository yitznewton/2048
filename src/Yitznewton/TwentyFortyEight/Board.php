<?php

namespace Yitznewton\TwentyFortyEight;

class Board
{
    const EMPTY_CELL = -1;

    private $grid;
    private $score;

    /**
     * @param int[][] $grid
     * @param int $score
     */
    public function __construct(array $grid, $score = 0)
    {
        $this->grid = $grid;
        $this->score = $score;
    }

    /**
     * @return bool
     */
    public function hasPossibleMoves()
    {
        return null;
    }

    /**
     * @return int
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * @return int[][]
     */
    public function getGrid()
    {
        return $this->grid;
    }

    /**
     * @param mixed $move One of the values in the Move pseudo-enum
     * @return Board
     */
    public function addMove($move)
    {
        $newGrid = $this->flip($this->grid, $move);

        for ($i = 0; $i < count($newGrid); $i++) {
            for ($j = 0; $j < count($newGrid[$i]) - 1; $j++) {
                $cell = $newGrid[$i][$j];

                if ($cell == Board::EMPTY_CELL) {
                    $newGrid[$i] = $this->shift($newGrid[$i], $j);
                    continue;
                }

                $adjacentCell = $newGrid[$i][$j+1];

                if ($cell == $adjacentCell) {
                    $newGrid[$i][$j] += $adjacentCell;
                    $newGrid[$i] = $this->shift($newGrid[$i], $j+1);
                }
            }
        }
        
        return new Board($this->unflip($newGrid, $move));
    }

    private function flip($grid, $move)
    {
        $move;  // PHPMD
        return $grid;
    }

    private function unflip($grid, $move)
    {
        $move;  // PHPMD
        return $grid;
    }

    private function shift($grid, $shiftPoint)
    {
        $firstSegment = array_slice($grid, 0, $shiftPoint);
        $secondSegment = array_slice($grid, $shiftPoint + 1);
        return array_merge($firstSegment, $secondSegment, [Board::EMPTY_CELL]);
    }
}
