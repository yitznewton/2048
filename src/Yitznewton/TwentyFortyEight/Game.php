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
        $cellInjector = new CellInjector();
        $row = array_fill(0, $this->size, Board::EMPTY_CELL);
        $grid = array_fill(0, $this->size, $row);
        $grid = $cellInjector->injectInto($grid);
        $grid = $cellInjector->injectInto($grid);

        $board = new Board($grid);
        $score = 0;
        $this->output->renderBoard($grid, $score);

        $scorer = new Scorer();

        while ($board->hasPossibleMoves()) {
            try {
                $move = $this->input->getMove();
            } catch (UnrecognizedInputException $e) {
                // ignore this input, and listen again
                continue;
            }

            $score += $scorer->forMove($grid, $move);
            $grid = $board->addMove($move);
            $grid = $cellInjector->injectInto($grid);
            $board = new Board($grid);
            $this->output->renderBoard($grid, $score);
        }

        $this->output->renderGameOver($score);
    }
}
