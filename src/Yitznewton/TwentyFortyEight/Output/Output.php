<?php

namespace Yitznewton\TwentyFortyEight\Output;

use Yitznewton\TwentyFortyEight\Board;

interface Output
{
    public function render(Board $board);
}
