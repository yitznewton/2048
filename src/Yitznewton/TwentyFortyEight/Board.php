<?php

namespace Yitznewton\TwentyFortyEight;

interface Board
{
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
     * @return array
     */
    public function getGrid();
}
