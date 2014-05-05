<?php

namespace Yitznewton\TwentyFortyEight\Input;

use Yitznewton\TwentyFortyEight\Move;

class ConsoleKeyboardInput implements Input
{
    private $originalTerminalSettings;

    public function __construct()
    {
        $this->originalTerminalSettings = `stty -g`;
        system('stty -icanon');
    }

    public function __destruct()
    {
        system("stty '" . $this->originalTerminalSettings . "'");
    }

    /**
     * @throws \UnexpectedValueException
     * @return mixed
     */
    public function getMove()
    {
        $char = $this->getCharFromKeyboard();

        switch (strtolower($char)) {
            case 'w':
                return Move::UP;
            case 'a':
                return Move::LEFT;
            case 's':
                return Move::DOWN;
            case 'd':
                return Move::RIGHT;
            default:
                throw new \UnexpectedValueException('Invalid character: ' . $char);
        }
    }

    /**
     * @return int
     */
    private function getCharFromKeyboard()
    {
        return fread(STDIN, 1);
    }
}
