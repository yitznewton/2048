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
    private $scorer;
    private $score;

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
        $this->scorer = new Scorer();
        $this->score = 0;
    }

    public function run()
    {
        $grid = $this->createGrid($this->size);
        $grid = $this->injectRandom($grid, 2);

        $this->output->renderBoard($grid, $this->score);

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

            $grid = $this->takeTurn($grid, $move, $moveCalculator);

            $this->output->renderBoard($grid, $this->score);

            if ($this->hasWinningTile($grid)) {
                $this->output->renderWin($this->winningTile);
                break;
            }

            $moveCalculator = new MoveCalculator($grid);
        }

        $this->output->renderGameOver($this->score);
    }

    private function injectRandom($grid, $numberOfCells)
    {
        $randomChoices = [2,4];

        for ($i = 0; $i < $numberOfCells; $i++) {
            $randomNumber = $randomChoices[rand(0, 1)];
            $grid = $grid->replaceRandom(EMPTY_CELL, $randomNumber);
        }

        return $grid;
    }

    /**
     * @param int $size
     * @return Grid
     */
    private function createGrid($size)
    {
        return Grid::fromArray(array_map(function () use ($size) {
            return array_fill(0, $size, EMPTY_CELL);
        }, range(0, $size-1)));
    }


    private function hasWinningTile($grid)
    {
        return $grid->reduce(function ($carry, $cell) {
            return $carry || $cell >= $this->winningTile;
        }, false);
    }

    private function takeTurn($grid, $move, $moveCalculator)
    {
        $this->score += $this->scorer->forMove($grid, $move);
        $grid = $moveCalculator->makeMove($move);
        $grid = $this->injectRandom($grid, 1);

        return $grid;
    }
}
