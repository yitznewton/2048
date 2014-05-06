<?php

namespace Yitznewton\TwentyFortyEight\Input;

class ConsoleKeyboardInput extends MappedInput
{
    private $originalTerminalSettings;

    /**
     * @param array $keyMap
     */
    public function __construct(array $keyMap)
    {
        parent::__construct($keyMap);

        $this->originalTerminalSettings = `stty -g`;
        system('stty -icanon');
    }

    public function __destruct()
    {
        system("stty '" . $this->originalTerminalSettings . "'");
    }

    /**
     * @return int
     */
    protected function getCharFromDevice()
    {
        return fread(STDIN, 1);
    }
}
