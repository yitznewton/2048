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
    private $cellInjector;
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
        $this->cellInjector = new CellInjector();
        $this->score = 0;
    }

    public function run()
    {
        //$grid = $this->createEmptyGrid($this->size);
        $grid = Grid::createFilled($this->size, EMPTY_CELL);
        $grid = $this->injectRandom($grid, 2);
        var_dump($grid->toArray());
        exit;

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

        return array_reduce(range(0, $numberOfCells - 1), function ($carry) use ($randomChoices) {
            $randomNumber = $randomChoices[rand(0, 1)];
            return $carry->replaceRandom(EMPTY_CELL, $randomNumber);
        }, $grid);
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
        $grid = $this->cellInjector->injectInto($grid);

        return $grid;
    }

    private function flatten(array $grid)
    {
        return array_reduce($grid, function ($carry, $row) {
            return array_merge($carry, $row);
        }, []);
    }
}
