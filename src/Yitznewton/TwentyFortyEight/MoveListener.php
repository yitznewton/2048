<?php

namespace Yitznewton\TwentyFortyEight;

interface MoveListener
{
    /**
     * @param array $cells
     * @return void
     */
    public function addCollapseEvent(array $cells);
}
