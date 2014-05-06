<?php

namespace Yitznewton\TwentyFortyEight\Output;

use Yitznewton\TwentyFortyEight\Board;

class ConsoleOutput implements Output
{
    const BOARD_WIDTH = 26;

    /**
     * @param Board $board
     * @return void
     */
    public function renderBoard(Board $board)
    {
        $this->clearScreen();
        $this->printHeader($board->getScore());
        $this->printBoard($board);
    }

    /**
     * @param int $score
     */
    public function renderGameOver($score)
    {
        echo "\n" . 'Good game! Your score was ' . $score . "\n\n";
    }

    /**
     * @param int $score
     */
    private function printHeader($score)
    {
        $score = 'SCORE: ' . $score;
        $spaces = str_repeat(' ', self::BOARD_WIDTH - 4 - strlen($score));
        echo $score . $spaces . '2048' . "\n\n";
    }

    private function printBoard(Board $board)
    {
        $grid = $board->getGrid();

        $this->printSolidLine(self::BOARD_WIDTH);

        foreach ($grid as $row) {
            $this->printRow($row);
        }

        $this->printSolidLine(self::BOARD_WIDTH);
    }

    private function printRow(array $row)
    {
        echo '|';

        $centerer = new TextCenterer(TextCenterer::RESOLVE_LEFT);

        foreach ($row as $cell) {
            $cellString = $cell ?: '';
            echo $centerer->centerText($cellString, 6);
        }

        echo "|\n";
    }

    private function printSolidLine($length)
    {
        echo '+' . str_repeat('-', $length - 2) . '+' . "\n";
    }

    private function clearScreen()
    {
        echo "\033[2J\033[;H";
    }
}
