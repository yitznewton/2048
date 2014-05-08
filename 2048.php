<?php

use Yitznewton\TwentyFortyEight\InitialBoard;
use Yitznewton\TwentyFortyEight\Input\Device\KeyboardInputDevice;
use Yitznewton\TwentyFortyEight\Input\MappedInput;
use Yitznewton\TwentyFortyEight\Input\UnrecognizedInputException;
use Yitznewton\TwentyFortyEight\Move;
use Yitznewton\TwentyFortyEight\Output\ConsoleOutput;
use Yitznewton\TwentyFortyEight\Scorer;

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

$board = new InitialBoard();
$scorer = new Scorer();
$score = 0;
$output->renderBoard($board, $score);

while ($board->hasPossibleMoves()) {
    try {
        $move = $input->getMove();
    } catch (UnrecognizedInputException $e) {
        // ignore this input, and listen again
        continue;
    }

    $score += $scorer->forMove($board->getGrid(), $move);
    $board = $board->addMove($move);
    $output->renderBoard($board, $score);
}

$output->renderGameOver($score);
