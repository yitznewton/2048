<?php

namespace Yitznewton\TwentyFortyEight;

use Yitznewton\TwentyFortyEight\Input\Input;
use Yitznewton\TwentyFortyEight\Input\UnrecognizedInputException;
use Yitznewton\TwentyFortyEight\Output\Output;

class Game
{
    private $size;
    private $input;
    private $output;

    /**
     * @param int $size
     * @param Input $input
     * @param Output $output
     */
    public function __construct($size, Input $input, Output $output)
    {
        $this->size = $size;
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
            $moveCalculator = new MoveCalculator($grid);
        }

        $this->output->renderGameOver($score);
    }

    /**
     * @param int $size
     * @return array
     */
    private function createEmptyGrid($size)
    {
        $row = array_fill(0, $size, EMPTY_CELL);
        return array_fill(0, $size, $row);
    }
}
