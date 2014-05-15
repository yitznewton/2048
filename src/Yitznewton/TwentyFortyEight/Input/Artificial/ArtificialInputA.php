<?php

namespace Yitznewton\TwentyFortyEight\Input\Artificial;

use Yitznewton\TwentyFortyEight\Grid;
use Yitznewton\TwentyFortyEight\Input\Input;
use Yitznewton\TwentyFortyEight\Move\Move;
use Yitznewton\TwentyFortyEight\Move\MoveMaker;

class ArtificialInputA implements Input
{
    private $grid;

    /**
     * @param Grid $grid
     */
    public function __construct(Grid $grid)
    {
        $this->grid = $grid;
    }

    /**
     * @return mixed
     */
    public function getMove()
    {
        $moveMaker = new MoveMaker($this->grid);

        return $moveMaker->getPossibleMoves()[0];
    }
}
