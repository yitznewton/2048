<?php

namespace Yitznewton\TwentyFortyEight\TestDoubles;

use Yitznewton\TwentyFortyEight\Board;

class BoardStub implements Board
{
    private $grid;

    /**
     * @param array $grid
     */
    public function __construct(array $grid)
    {
        $this->grid = $grid;
    }

    /**
     * @return int
     */
    public function getScore()
    {
        return 105678;
    }

    /**
     * @return array
     */
    public function getGrid()
    {
        return $this->grid;
    }
}
