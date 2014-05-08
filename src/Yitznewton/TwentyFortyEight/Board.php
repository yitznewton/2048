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
        $newGrid = $this->grid;

        for ($i = 0; $i < count($newGrid); $i++) {
            $row = $newGrid[$i];

            for ($j = 0; $j < count($row) - 1; $j++) {
                $cell = $row[$j];

                if ($cell == Board::EMPTY_CELL) {
                    continue;
                }

                $adjacentCell = $row[$j+1];

                if ($cell == $adjacentCell) {
                    $newGrid[$i][$j] += $adjacentCell;
                    $newGrid[$i][$j+1] = Board::EMPTY_CELL;
                }
            }
        }
        
        return new Board($newGrid);
    }
}
