<?php

use Yitznewton\TwentyFortyEight\Board;
use Yitznewton\TwentyFortyEight\Input\ConsoleKeyboardInput;
use Yitznewton\TwentyFortyEight\Input\UnrecognizedInputException;
use Yitznewton\TwentyFortyEight\Output\ConsoleOutput;

require_once __DIR__ . '/vendor/autoload.php';

$input = new ConsoleKeyboardInput();
$output = new ConsoleOutput();

$board = new Board();
$board->initialize();
$output->renderBoard($board);

while ($board->hasPossibleMoves()) {
    try {
        $move = $input->getMove();
    } catch (UnrecognizedInputException $e) {
        // ignore this input, and listen again
        continue;
    }

    $board->addMove($move);
    $output->renderBoard($board);
}

$output->renderGameOver($board->getScore());
