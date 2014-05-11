<?php

namespace Yitznewton\TwentyFortyEight\Output;

use Yitznewton\TwentyFortyEight\Grid;

interface Output
{
    /**
     * @param Grid $grid
     * @param int $score
     * @return void
     */
    public function renderBoard(Grid $grid, $score);

    /**
     * @param int $score
     * @return void
     */
    public function renderGameOver($score);

    /**
     * @param int $winningTileValue
     * @return void
     */
    public function renderWin($winningTileValue);
}
