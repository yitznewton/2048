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
    public function __construct(array $grid, $score)
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
        $move;  // PHPMD
        return new Board();
    }
}
