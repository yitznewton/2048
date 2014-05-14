<?php

namespace Yitznewton\TwentyFortyEight\Tests\Move;

use Yitznewton\TwentyFortyEight\Tests\Doubles\Move\StackListener;

class StackListenerTest extends \PHPUnit_Framework_TestCase
{
    public function testAddCollapseEvent()
    {
        $cells = [3,3];
        $expected = [['addCollapseEvent', $cells]];
        $listener = new StackListener();
        $listener->addCollapseEvent($cells);
        $this->assertEquals($expected, $listener->getEvents());
    }
}
