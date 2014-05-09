<?php

namespace Yitznewton\TwentyFortyEight;

use Yitznewton\TwentyFortyEight\Input\Input;
use Yitznewton\TwentyFortyEight\Input\UnrecognizedInputException;
use Yitznewton\TwentyFortyEight\Output\Output;

class Game
{
    private $size;
    private $winningTile;
    private $input;
    private $output;

    /**
     * @param int $size
     * @param int $winningTile
     * @param Input $input
     * @param Output $output
     */
    public function __construct($size, $winningTile, Input $input, Output $output)
    {
        $this->size = $size;
        $this->winningTile = $winningTile;
        $this->input = $input;
        $this->output = $output;
    }

    public function run()
    {
        $grid = $this->createEmptyGrid($this->size);

        $cellInjector = new CellInjector();
        $grid = $cellInjector->injectInto($grid);
        $grid = $cellInjector->injectInto($grid);

        $score = 0;
        $this->output->renderBoard($grid, $score);

        $scorer = new Scorer();
        $moveCalculator = new MoveCalculator($grid);

        while ($moveCalculator->hasPossibleMoves()) {
            try {
                $move = $this->input->getMove();
            } catch (UnrecognizedInputException $e) {
                // ignore this input, and listen again
                continue;
            }

            if (!$moveCalculator->isPossibleMove($move)) {
                // ignore
                continue;
            }

            $score += $scorer->forMove($grid, $move);
            $grid = $moveCalculator->makeMove($move);
            $grid = $cellInjector->injectInto($grid);
            $this->output->renderBoard($grid, $score);

            if ($this->hasWinningTile($grid)) {
                $this->output->renderWin($this->winningTile);
                break;
            }

            $moveCalculator = new MoveCalculator($grid);
        }

        $this->output->renderGameOver($score);
    }

    private function createEmptyGrid($size)
    {
        $emptyRow = array_fill(0, $size, EMPTY_CELL);
        return array_fill(0, $size, $emptyRow);
    }

    private function hasWinningTile($grid)
    {
        return in_array($this->winningTile, $this->flatten($grid));
    }

    private function flatten(array $grid)
    {
        return array_reduce($grid, function ($carry, $row) {
            return array_merge($carry, $row);
        }, []);
    }
}
