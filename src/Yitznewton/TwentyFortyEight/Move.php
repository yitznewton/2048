<?php

namespace Yitznewton\TwentyFortyEight;

/**
 * A pseudo-enum
 */
abstract class Move
{
    const UP = 1;
    const DOWN = 2;
    const LEFT = 3;
    const RIGHT = 4;

    public static function getAll()
    {
        return [
            self::UP,
            self::DOWN,
            self::LEFT,
            self::RIGHT,
        ];
    }
}
