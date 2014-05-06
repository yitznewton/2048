<?php

namespace Yitznewton\TwentyFortyEight;

interface Board
{
    /**
     * @return int
     */
    public function getScore();

    /**
     * @return array
     */
    public function getGrid();
}
