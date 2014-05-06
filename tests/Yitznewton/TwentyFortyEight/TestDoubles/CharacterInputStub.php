<?php

namespace Yitznewton\TwentyFortyEight\TestDoubles;

use Yitznewton\TwentyFortyEight\Input\Device\CharacterInputDevice;

class CharacterInputStub implements CharacterInputDevice
{
    private $char;

    /**
     * @param string $char
     */
    public function setChar($char)
    {
        $this->char = $char;
    }

    /**
     * @return mixed
     */
    public function getChar()
    {
        return $this->char;
    }
}
