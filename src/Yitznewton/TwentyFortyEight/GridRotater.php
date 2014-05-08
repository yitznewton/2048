<?php

namespace Yitznewton\TwentyFortyEight;

class GridRotater
{
    /**
     * @param array $grid
     * @param mixed $move
     * @return array
     */
    public function rotateForMove(array $grid, $move)
    {
        return $this->rotate($grid, $this->rotationsForMove($move));
    }

    /**
     * @param array $grid
     * @return array
     */
    public function unrotateForMove(array $grid, $move)
    {
        return $this->rotate($grid, 4 - $this->rotationsForMove($move));
    }

    /**
     * @param array $grid
     * @param int $numberOfRotations
     * @return array
     */
    public function rotate(array $grid, $numberOfRotations)
    {
        if ($numberOfRotations == 0) {
            return $grid;
        }

        $rotated = [];

        for ($i = 0; $i < count($grid); $i++) {
            for ($j = 0; $j < count($grid); $j++) {
                $rotated[$i][$j] = $grid[$j][$i];
            }
        }

        return $this->rotate(array_map('array_reverse', $rotated), $numberOfRotations-1);
    }

    private function rotationsForMove($move)
    {
        switch ($move) {
            case Move::LEFT:
                return 0;
            case Move::DOWN:
                return 1;
            case Move::RIGHT:
                return 2;
            case Move::UP:
                return 3;
            default:
                throw new \UnexpectedValueException('Unrecognized move');
        }
    }
}
