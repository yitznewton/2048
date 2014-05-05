<?php

namespace Yitznewton\TwentyFortyEight\Input;

use Yitznewton\TwentyFortyEight\Board;

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
                return Board::MOVE_UP;
            case 'a':
                return Board::MOVE_LEFT;
            case 's':
                return Board::MOVE_DOWN;
            case 'd':
                return Board::MOVE_RIGHT;
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
