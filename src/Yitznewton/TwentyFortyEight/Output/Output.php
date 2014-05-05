<?php

namespace Yitznewton\TwentyFortyEight\Output;

use Yitznewton\TwentyFortyEight\Board;

interface Output
{
    /**
     * @param Board $board
     * @return void
     */
    public function render(Board $board);
}
