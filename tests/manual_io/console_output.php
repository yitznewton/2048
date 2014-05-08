<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Yitznewton\TwentyFortyEight\Board;
use Yitznewton\TwentyFortyEight\Output\ConsoleOutput;

$output = new ConsoleOutput();

$board = new Board([
    [2,4,1024,8],
    [2,256,4,8],
    [-1,4,8,8],
    [8,-1,16,4],
], 33487);

$output->renderBoard($board, 239348);
$output->renderGameOver(1252345);

$board = new Board([
    [2,4,1024,8,16],
    [2,256,4,8,256],
    [-1,4,8,8,1024],
    [8,-1,16,4, 4],
    [8,2,16,64,-1],
], 134875);

$output->renderBoard($board, 2314);
$output->renderGameOver(34987);
