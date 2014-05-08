<?php

namespace Yitznewton\TwentyFortyEight\Output;

use Yitznewton\TwentyFortyEight\Board;

interface Output
{
    /**
     * @param Board $board
     * @param int $score
     * @return void
     */
    public function renderBoard(Board $board, $score);

    /**
     * @param int $score
     * @return void
     */
    public function renderGameOver($score);
}
