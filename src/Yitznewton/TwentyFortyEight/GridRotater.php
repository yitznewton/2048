<?php

namespace Yitznewton\TwentyFortyEight;

class GridRotater
{
    /**
     * @param array $grid
     * @return array
     */
    public function rotateForMove(array $grid)
    {
        return $grid;
    }

    /**
     * @param array $grid
     * @return array
     */
    public function unrotateForMove(array $grid)
    {
        return $grid;
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
}
