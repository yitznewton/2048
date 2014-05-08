<?php

namespace Yitznewton\TwentyFortyEight\CellInjector;

interface CellInjector
{
    /**
     * @param array $grid
     * @return array
     */
    public function inject(array $grid);
}
