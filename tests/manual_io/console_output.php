<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Yitznewton\TwentyFortyEight\Board;
use Yitznewton\TwentyFortyEight\Output\ConsoleOutput;

$output = new ConsoleOutput();
$board = new Board();
$output->renderBoard($board);
$output->renderGameOver($board->getScore());
