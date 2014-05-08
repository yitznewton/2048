<?php

namespace Yitznewton\TwentyFortyEight\CellInjector;

class NullCellInjector implements CellInjector
{
    /**
     * @param array $grid
     * @return array
     */
    public function inject(array $grid)
    {
        return $grid;
    }
}
