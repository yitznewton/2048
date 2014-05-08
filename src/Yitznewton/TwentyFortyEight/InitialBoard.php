<?php

namespace Yitznewton\TwentyFortyEight;

class InitialBoard extends Board
{
    public function __construct()
    {
        $board = [
            [-1,-1,2,-1],
            [-1,-1,-1,2],
            [-1,-1,-1,-1],
            [-1,-1,-1,-1],
        ];
        parent::__construct($board);
    }
}
