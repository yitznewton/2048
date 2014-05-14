<?php

use Yitznewton\TwentyFortyEight\Game;
use Yitznewton\TwentyFortyEight\Input\Device\KeyboardInputDevice;
use Yitznewton\TwentyFortyEight\Input\MappedInput;
use Yitznewton\TwentyFortyEight\Move\Move;
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
    "\033[A" => Move::UP,
    "\033[D" => Move::LEFT,
    "\033[B" => Move::DOWN,
    "\033[C" => Move::RIGHT,
], $device);

$output = new ConsoleOutput();

$game = new Game(4, 2048, $input, $output);
$game->run();
