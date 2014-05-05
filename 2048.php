<?php

use Yitznewton\TwentyFortyEight\Board;
use Yitznewton\TwentyFortyEight\Input\ConsoleKeyboardInput;
use Yitznewton\TwentyFortyEight\Output\ConsoleOutput;

require_once __DIR__ . '/vendor/autoload.php';

$input = new ConsoleKeyboardInput();
$output = new ConsoleOutput();

$board = new Board();
$board->initialize();
$output->renderBoard($board);

while ($board->hasPossibleMoves()) {
    $move = $input->getMove();
    $board->addMove($move);
    $output->renderBoard($board);
}

$output->renderGameOver($board->getScore());
