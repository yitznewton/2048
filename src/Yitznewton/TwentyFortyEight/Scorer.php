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
        return array_sum(array_map(function ($row) {
            $rowObj = new Collection($row);
            return $this->forRow($rowObj);
        }, $rotatedGrid));
    }

    private function forRow($row, $cumulative = 0)
    {
        $row = $row->delete(EMPTY_CELL);

        if ($row->count() < 2) {
            return $cumulative;
        }

        if ($row->index(0) == $row->index(1)) {
            $cumulative += $row->index(0) * 2;
            return $this->forRow($row->slice(2), $cumulative);
        }

        return $this->forRow($row->slice(1), $cumulative);
    }
}
