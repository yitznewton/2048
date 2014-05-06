<?php

namespace Yitznewton\TwentyFortyEight;

class Board
{
    /**
     * @return int
     */
    public function getScore()
    {
        return -999;
    }

    /**
     * @return array
     */
    public function getGrid()
    {
        throw new \BadMethodCallException('not defined');
    }
}
