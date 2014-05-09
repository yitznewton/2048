<?php

namespace Yitznewton\TwentyFortyEight;

class Scorer
{
    /**
     * @param array $startingGrid
     * @param mixed $move
     * @return int
     */
    public function forMove(array $startingGrid, $move)
    {
        $rotatedGrid = (new GridRotater())->rotateForMove($startingGrid, $move);
        return array_sum(array_map([$this, 'forRow'], $rotatedGrid));
    }

    private function forRow($row, $cumulative = 0)
    {
        if (count($row) < 2) {
            return $cumulative;
        }

        if ($row[0] == EMPTY_CELL) {
            return $this->forRow(array_slice($row, 1), $cumulative);
        }

        if ($row[0] == $row[1]) {
            $cumulative += $row[0] + $row[1];
            return $this->forRow(array_slice($row, 2), $cumulative);
        }

        return $this->forRow(array_slice($row, 1), $cumulative);
    }
}
