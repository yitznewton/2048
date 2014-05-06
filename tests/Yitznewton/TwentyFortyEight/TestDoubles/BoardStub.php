<?php

namespace Yitznewton\TwentyFortyEight\TestDoubles;

use Yitznewton\TwentyFortyEight\Board;

class BoardStub extends Board
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
     * @return array
     */
    public function getGrid()
    {
        return $this->grid;
    }
}
