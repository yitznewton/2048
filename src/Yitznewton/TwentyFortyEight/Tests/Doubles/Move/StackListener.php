<?php

namespace Yitznewton\TwentyFortyEight\Tests\Doubles\Move;

use Yitznewton\TwentyFortyEight\Move\MoveListener;

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
