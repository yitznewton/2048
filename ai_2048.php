<?php

use Yitznewton\TwentyFortyEight\Game;
use Yitznewton\TwentyFortyEight\Input\Artificial\ArtificialInputA;
use Yitznewton\TwentyFortyEight\Input\DelayedProxyInput;
use Yitznewton\TwentyFortyEight\Input\Device\KeyboardInputDevice;
use Yitznewton\TwentyFortyEight\Input\MappedInput;
use Yitznewton\TwentyFortyEight\Move\Move;
use Yitznewton\TwentyFortyEight\Output\ConsoleOutput;

require_once __DIR__ . '/vendor/autoload.php';

$device = new KeyboardInputDevice();

$aiInput = new ArtificialInputA();
$delayedInput = new DelayedProxyInput($aiInput);
$output = new ConsoleOutput();

$game = new Game(4, 2048, $delayedInput, $output);
$game->run();
