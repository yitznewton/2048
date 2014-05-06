<?php

namespace Yitznewton\TwentyFortyEight\Input;

use Yitznewton\TwentyFortyEight\InputDevice\CharacterInputDevice;

class MappedInput implements Input
{
    private $keyMap;

    /**
     * @param array $keyMap
     * @param CharacterInputDevice $device
     */
    public function __construct(array $keyMap, CharacterInputDevice $device)
    {
        $this->keyMap = $keyMap;
        $this->device = $device;
    }

    /**
     * @throws \UnexpectedValueException
     * @return mixed
     */
    public function getMove()
    {
        $char = $this->device->getChar();

        if (isset($this->keyMap[$char])) {
            return $this->keyMap[$char];
        }

        throw new \UnexpectedValueException('Invalid character: ' . $char);
    }
}
