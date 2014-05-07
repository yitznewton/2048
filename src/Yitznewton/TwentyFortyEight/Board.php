<?php

namespace Yitznewton\TwentyFortyEight;

interface Board
{
    const EMPTY_CELL = -1;

    /**
     * @return void
     */
    public function initialize();

    /**
     * @return bool
     */
    public function hasPossibleMoves();

    /**
     * @param mixed $move One of the values in the Move pseudo-enum
     * @return void
     */
    public function addMove($move);

    /**
     * @return int
     */
    public function getScore();

    /**
     * @return int[][]
     */
    public function getGrid();
}
