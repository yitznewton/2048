<?php

namespace Yitznewton\TwentyFortyEight\Tests\Doubles;

use Yitznewton\TwentyFortyEight\MoveListener;

class StackListener implements MoveListener
{
    private $events;

    public function __construct()
    {
        $this->events = [];
    }

    /**
     * @return array
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * @param array $cells
     */
    public function addCollapseEvent(array $cells)
    {
        $this->events[] = [__FUNCTION__, $cells];
    }
}
