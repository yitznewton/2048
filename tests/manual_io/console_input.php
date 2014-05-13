<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Yitznewton\TwentyFortyEight\Input\MappedInput;
use Yitznewton\TwentyFortyEight\Input\Device\KeyboardInputDevice;
use Yitznewton\TwentyFortyEight\Move\Move;

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

while (true) {
    try {
        var_dump($input->getMove());
    } catch (\UnexpectedValueException $e) {
        var_dump($e->getMessage());
    }
}
