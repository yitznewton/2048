<?php

namespace Yitznewton\TwentyFortyEight\Input;

use Yitznewton\TwentyFortyEight\Grid;

class DelayedProxyInput implements Input
{
    const DEFAULT_MICROSECONDS = 200000;

    private $inputToProxy;
    private $microseconds;

    public function __construct(Input $inputToProxy, $microseconds = self::DEFAULT_MICROSECONDS)
    {
        $this->inputToProxy = $inputToProxy;
        $this->microseconds = $microseconds;
    }

    public function getMove(Grid $grid)
    {
        usleep($this->microseconds);
        return $this->inputToProxy->getMove($grid);
    }
}
