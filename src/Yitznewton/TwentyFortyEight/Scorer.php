<?php

namespace Yitznewton\TwentyFortyEight;

class Scorer
{
    /**
     * @param array $startingGrid
     * @param int $cumulative
     * @return int
     */
    public function forMove(array $startingGrid, $cumulative = 0)
    {
        $row = $startingGrid[0];

        if (count($row) < 2) {
            return $cumulative;
        }

        if ($row[0] == $row[1]) {
            $cumulative += $row[0] + $row[1];
            return $this->forMove([array_slice($row, 2)], $cumulative);
        }

        return $this->forMove([array_slice($row, 1)], $cumulative);
    }
}
