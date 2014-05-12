<?php

namespace Yitznewton\TwentyFortyEight;

class Scorer
{
    /**
     * @param Grid $startingGrid
     * @param mixed $move
     * @return int
     */
    public function forMove(Grid $startingGrid, $move)
    {
        $rotatedGrid = (new GridRotater())->rotateForMove($startingGrid, $move);

        return array_sum($rotatedGrid->map(function ($row) {
            return $this->forRow($row);
        }));
    }

    private function forRow($row, $cumulative = 0)
    {
        $row = $row->delete(Grid::EMPTY_CELL);

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
