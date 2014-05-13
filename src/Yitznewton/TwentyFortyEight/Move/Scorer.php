<?php

namespace Yitznewton\TwentyFortyEight\Move;

class Scorer implements MoveListener
{
    private $score = 0;

    /**
     * @param array $cells
     */
    public function addCollapseEvent(array $cells)
    {
        $this->score += array_sum($cells);
    }

    /**
     * @return int
     */
    public function getScore()
    {
        return $this->score;
    }
}
