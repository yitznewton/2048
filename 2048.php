<?php

require_once __DIR__ . '/vendor/autoload.php';

$input = new KeyboardInput();
$output = new ConsoleOutput();

$board = new Board();
$board->initialize();
$output->render($board);

while ($board->hasEmptySlots()) {
    $move = $input->getMove();
    $board->addMove($move);
    $output->render($board);
}
