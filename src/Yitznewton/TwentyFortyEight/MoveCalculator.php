<?php

namespace Yitznewton\TwentyFortyEight;

class MoveCalculator
{
    private $grid;

    /**
     * @param Grid $grid
     */
    public function __construct(Grid $grid)
    {
        $this->grid = $grid;
    }

    /**
     * @return bool
     */
    public function hasPossibleMoves()
    {
        if ($this->grid->contains(Grid::EMPTY_CELL)) {
            return true;
        }

        $possibilityByMove = array_map([$this, 'isPossibleMove'], [Move::LEFT, Move::UP]);
        return (bool) array_filter($possibilityByMove);
    }

    /**
     * @param mixed $move
     * @return bool
     */
    public function isPossibleMove($move)
    {
        return $this->makeMove($move) != $this->grid;
    }

    /**
     * @param mixed $move One of the values in the Move pseudo-enum
     * @return array
     */
    public function makeMove($move)
    {
        $rotater = new GridRotater($move);

        $rotatedGrid = $rotater->rotateForMove($this->grid, $move);

        $calculatedGrid = Grid::fromArray($rotatedGrid->map(function ($row) {
            return $this->collapseAndPadRow($row);
        }));

        return $rotater->unrotateForMove($calculatedGrid, $move);
    }

    private function collapseAndPadRow($row)
    {
        $collapsedRow = $this->collapseRow($row);
        return $this->padRowWithEmptyCells($collapsedRow, $row->count());
    }

    private function collapseRow(Collection $row)
    {
        $row = $row->delete(Grid::EMPTY_CELL);

        if ($row->count() < 2) {
            return $row;
        }

        if ($row->index(0) == $row->index(1)) {
            $sum = $row->index(0) * 2;
            $newFirst = new Collection([$sum]);
            return $newFirst->merge($this->collapseRow($row->slice(2)));
        }

        $newFirst = $row->slice(0,1);
        return $newFirst->merge($this->collapseRow($row->slice(1)));
    }

    private function padRowWithEmptyCells(Collection $row, $size)
    {
        while ($row->count() < $size) {
            $row = $row->append(Grid::EMPTY_CELL);
        }

        return $row->toArray();
    }
}
