<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Yitznewton\TwentyFortyEight\Grid;
use Yitznewton\TwentyFortyEight\Output\ConsoleOutput;

$output = new ConsoleOutput();

$grid = Grid::fromArray([
    [2,4,1024,8],
    [2,256,4,8],
    [-1,4,8,8],
    [8,-1,16,4],
]);

$output->renderBoard($grid, 239348);
$output->renderGameOver(1252345);

$grid = Grid::fromArray([
    [2,4,1024,8,16],
    [2,256,4,8,256],
    [-1,4,8,8,1024],
    [8,-1,16,4, 4],
    [8,2,16,64,-1],
]);

$output->renderBoard($grid, 2314);
$output->renderGameOver(34987);
