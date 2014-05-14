<?php

namespace Yitznewton\TwentyFortyEight\Tests\Move;

use Yitznewton\TwentyFortyEight\Move\Scorer;

class ScorerTest extends \PHPUnit_Framework_TestCase
{
    public function testRegisterAndGetScore()
    {
        $scorer = new Scorer();
        $scorer->addCollapseEvent([3,3]);
        $this->assertEquals(6, $scorer->getScore());
    }
}
