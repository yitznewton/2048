<?php

namespace Yitznewton\TwentyFortyEight\Input;

use Yitznewton\TwentyFortyEight\Grid;

class DelayedProxyInput implements Input
{
    const DEFAULT_SECONDS = 1;

    private $inputToProxy;
    private $seconds;

    public function __construct(Input $inputToProxy, $seconds = self::DEFAULT_SECONDS)
    {
        $this->inputToProxy = $inputToProxy;
        $this->seconds = $seconds;
    }

    public function getMove(Grid $grid)
    {
        sleep($this->seconds);
        return $this->inputToProxy->getMove($grid);
    }
}
