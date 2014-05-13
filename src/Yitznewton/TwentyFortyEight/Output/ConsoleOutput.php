<?php

namespace Yitznewton\TwentyFortyEight\Output;
use Yitznewton\TwentyFortyEight\Grid;

/**
 * @SuppressWarnings(PHPMD.TooManyMethods)
 */
class ConsoleOutput implements Output
{
    const CELL_WIDTH = 6;
    const GAME_TITLE = '2048';

    private $centerer;

    public function __construct()
    {
        $this->centerer = new TextCenterer(TextCenterer::RESOLVE_LEFT);
    }

    /**
     * @param array $grid
     * @param int $score
     * @return void
     */
    public function renderBoard(array $grid, $score)
    {
        $this->clearScreen();
        $this->printHeader($grid, $score);
        $this->printGrid($grid);
    }

    /**
     * @param int $score
     */
    public function renderGameOver($score)
    {
        echo "\n" . 'Good game! Your score was ' . $score . "\n\n";
    }

    /**
     * @param int $winningTileValue
     */
    public function renderWin($winningTileValue)
    {
        printf("\n". 'YYYYEEEEEEAH! You got the %d tile!!!!', $winningTileValue);
    }

    private function printHeader($grid, $score)
    {
        $boardWidth = $this->calculateBoardWidth($grid);
        $scoreString = 'SCORE: ' . $score;

        $spacesCount = $boardWidth - strlen(self::GAME_TITLE) - strlen($scoreString);
        $spaces = str_repeat(' ', $spacesCount);

        echo $scoreString . $spaces . self::GAME_TITLE . "\n\n";
    }

    private function printGrid($grid)
    {
        $boardWidth = $this->calculateBoardWidth($grid);

        $this->printSolidLine($boardWidth);

        for ($i = 0; $i < count($grid); $i++) {
            $row = $grid[$i];
            $this->printRow($row);

            if (!$this->isLastRow($i, $grid)) {
                $this->printBlankLine($boardWidth);
            }
        }

        $this->printSolidLine($boardWidth);
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
        if ($cell == Grid::EMPTY_CELL) {
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

    private function calculateBoardWidth($grid)
    {
        $combinedBorderWidth = 2;
        return count($grid) * self::CELL_WIDTH + $combinedBorderWidth;
    }

    private function clearScreen()
    {
        echo "\033[2J\033[;H";
    }
}
