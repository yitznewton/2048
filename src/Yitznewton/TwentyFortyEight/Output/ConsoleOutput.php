<?php

namespace Yitznewton\TwentyFortyEight\Output;

use Yitznewton\TwentyFortyEight\Board;

/**
 * @SuppressWarnings(PHPMD.TooManyMethods)
 */
class ConsoleOutput implements Output
{
    const BOARD_WIDTH = 26;
    const GAME_TITLE = '2048';

    private $centerer;

    public function __construct()
    {
        $this->centerer = new TextCenterer(TextCenterer::RESOLVE_LEFT);
    }

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
        echo $score . $spaces . self::GAME_TITLE . "\n\n";
    }

    private function printBoard(Board $board)
    {
        $grid = $board->getGrid();

        $this->printSolidLine(self::BOARD_WIDTH);

        for ($i = 0; $i < count($grid); $i++) {
            $row = $grid[$i];
            $this->printRow($row);

            if (!$this->isLastRow($i, $grid)) {
                $this->printBlankLine(self::BOARD_WIDTH);
            }
        }

        $this->printSolidLine(self::BOARD_WIDTH);
    }

    private function printRow(array $row)
    {
        echo '|';

        foreach ($row as $cell) {
            $cellString = $this->cellToString($cell);
            echo $this->centerer->centerText($cellString, 6);
        }

        echo "|\n";
    }

    private function printSolidLine($length)
    {
        echo '+' . str_repeat('-', $length - 2) . '+' . "\n";
    }

    private function printBlankLine($length)
    {
        echo '|' . str_repeat(' ', $length - 2) . '|' . "\n";
    }

    private function cellToString($cell)
    {
        if ($cell === 0) {
            return '';
        }

        return $cell;
    }

    /**
     * @SuppressWarnings(PHPMD.ShortVariable)
     */
    private function isLastRow($i, $grid)
    {
        return $i == count($grid) - 1;
    }

    private function clearScreen()
    {
        echo "\033[2J\033[;H";
    }
}
