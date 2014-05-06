<?php

namespace Yitznewton\TwentyFortyEight\InputDevice;

class KeyboardInputDevice implements CharacterInputDevice
{
    private $originalTerminalSettings;

    public function __construct()
    {
        $this->originalTerminalSettings = `stty -g`;
        system('stty -icanon -echo');
    }

    public function __destruct()
    {
        system("stty '" . $this->originalTerminalSettings . "'");
    }

    public function getChar()
    {
        return fread(STDIN, 1);
    }
}
