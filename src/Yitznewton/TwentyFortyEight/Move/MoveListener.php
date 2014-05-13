<?php

namespace Yitznewton\TwentyFortyEight\Move;

interface MoveListener
{
    /**
     * @param array $cells
     * @return void
     */
    public function addCollapseEvent(array $cells);
}
