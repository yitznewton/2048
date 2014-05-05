<?php

namespace Yitznewton\TwentyFortyEight\Output;

use Yitznewton\TwentyFortyEight\Board;

class ConsoleOutput implements Output
{
    const LINE_LENGTH = 48;

    /**
     * @param Board $board
     * @return void
     */
    public function render(Board $board)
    {
        $this->clearScreen();
        $this->printHeader($board->getScore());
        $this->printBoard($board);
    }

    /**
     * @param int $score
     */
    private function printHeader($score)
    {
        $score = 'SCORE: ' . $score;
        $spaces = str_repeat(' ', self::LINE_LENGTH - 4 - strlen($score));
        echo $score . $spaces . '2048' . "\n\n";
    }

    private function printBoard(Board $board)
    {
        echo 'board goes here' . "\n\n";
    }

    private function clearScreen()
    {
        echo "\033[2J\033[;H";
    }
}
