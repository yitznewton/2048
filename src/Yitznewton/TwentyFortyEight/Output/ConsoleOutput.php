<?php

namespace Yitznewton\TwentyFortyEight\Output;

use Yitznewton\TwentyFortyEight\Board;

/**
 * @SuppressWarnings(PHPMD.TooManyMethods)
 */
class ConsoleOutput implements Output
{
    const BOARD_WIDTH = 26;
    const CELL_WIDTH = 6;
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
        $this->printGrid($board->getGrid());
    }

    /**
     * @param int $score
     */
    public function renderGameOver($score)
    {
        echo "\n" . 'Good game! Your score was ' . $score . "\n\n";
    }

    /**
     * @param int $scoreString
     */
    private function printHeader($scoreString)
    {
        $scoreString = 'SCORE: ' . $scoreString;
        $spacesCount = self::BOARD_WIDTH - strlen(self::GAME_TITLE) - strlen($scoreString);
        $spaces = str_repeat(' ', $spacesCount);

        echo $scoreString . $spaces . self::GAME_TITLE . "\n\n";
    }

    private function printGrid(array $grid)
    {
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
            echo $this->centerer->centerText($cellString, self::CELL_WIDTH);
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
