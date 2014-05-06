<?php

namespace Yitznewton\TwentyFortyEight\Input;

abstract class MappedInput implements Input
{
    private $keyMap;

    /**
     * @param array $keyMap
     */
    public function __construct(array $keyMap)
    {
        $this->keyMap = $keyMap;
    }

    /**
     * @throws \UnexpectedValueException
     * @return mixed
     */
    public function getMove()
    {
        $char = $this->getCharFromDevice();

        if (isset($this->keyMap[$char])) {
            return $this->keyMap[$char];
        }

        throw new \UnexpectedValueException('Invalid character: ' . $char);
    }

    /**
     * @return mixed
     */
    abstract protected function getCharFromDevice();
}
