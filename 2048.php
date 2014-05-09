<?php

use Yitznewton\TwentyFortyEight\Board;
use Yitznewton\TwentyFortyEight\CellInjector;
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
$cellInjector = new CellInjector();

$size = 4;
$row = array_fill(0, $size, Board::EMPTY_CELL);
$grid = array_fill(0, $size, $row);
$grid = $cellInjector->injectInto($grid);
$grid = $cellInjector->injectInto($grid);

$board = new Board($grid);
$score = 0;
$output->renderBoard($grid, $score);

$scorer = new Scorer();

while ($board->hasPossibleMoves()) {
    try {
        $move = $input->getMove();
    } catch (UnrecognizedInputException $e) {
        // ignore this input, and listen again
        continue;
    }

    $score += $scorer->forMove($grid, $move);
    $grid = $board->addMove($move);
    $grid = $cellInjector->injectInto($grid);
    $board = new Board($grid);
    $output->renderBoard($grid, $score);
}

$output->renderGameOver($score);
