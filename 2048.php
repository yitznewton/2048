<?php

use Yitznewton\TwentyFortyEight\BoardImplementation;
use Yitznewton\TwentyFortyEight\Input\Device\KeyboardInputDevice;
use Yitznewton\TwentyFortyEight\Input\MappedInput;
use Yitznewton\TwentyFortyEight\Input\UnrecognizedInputException;
use Yitznewton\TwentyFortyEight\Move;
use Yitznewton\TwentyFortyEight\Output\ConsoleOutput;

require_once __DIR__ . '/vendor/autoload.php';

$device = new KeyboardInputDevice();

$input = new MappedInput([
    'w' => Move::UP,
    'a' => Move::LEFT,
    's' => Move::DOWN,
    'd' => Move::RIGHT,
    'i' => Move::UP,
    'j' => Move::LEFT,
    'k' => Move::DOWN,
    'l' => Move::RIGHT,
], $device);

$output = new ConsoleOutput();

$board = new BoardImplementation();
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
