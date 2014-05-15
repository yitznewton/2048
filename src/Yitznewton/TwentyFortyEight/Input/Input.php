<?php

namespace Yitznewton\TwentyFortyEight\Input;

use Yitznewton\TwentyFortyEight\Grid;

interface Input
{
    /**
     * @param Grid $grid
     * @return mixed
     */
    public function getMove(Grid $grid);
}
