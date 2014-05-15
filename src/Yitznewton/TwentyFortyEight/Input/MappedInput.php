<?php

namespace Yitznewton\TwentyFortyEight\Input;

use Yitznewton\TwentyFortyEight\Grid;
use Yitznewton\TwentyFortyEight\Input\Device\CharacterInputDevice;

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
     * @throws UnrecognizedInputException
     * @param Grid $grid
     * @return mixed
     */
    public function getMove(Grid $grid)
    {
        $char = $this->device->getChar();

        if (isset($this->keyMap[$char])) {
            return $this->keyMap[$char];
        }

        throw new UnrecognizedInputException('Unrecognized character: ' . $char);
    }
}
