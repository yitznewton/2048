<?php

namespace Yitznewton\TwentyFortyEight\Output;

interface Output
{
    /**
     * @param array $grid
     * @param int $score
     * @return void
     */
    public function renderBoard(array $grid, $score);

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
