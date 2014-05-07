<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Yitznewton\TwentyFortyEight\Output\ConsoleOutput;
use Yitznewton\TwentyFortyEight\TestDoubles\BoardStub;

$output = new ConsoleOutput();

$board = new BoardStub([
    [2,4,1024,8],
    [2,256,4,8],
    [-1,4,8,8],
    [8,-1,16,4],
]);

$output->renderBoard($board);
$output->renderGameOver($board->getScore());
