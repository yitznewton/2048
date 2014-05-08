<?php

namespace Yitznewton\TwentyFortyEight;

class Board
{
    const EMPTY_CELL = -1;

    private $grid;
    private $score;

    /**
     * @param int[][] $grid
     * @param int $score
     */
    public function __construct(array $grid, $score = 0)
    {
        $this->grid = $grid;
        $this->score = $score;
    }

    /**
     * @return bool
     */
    public function hasPossibleMoves()
    {
        return null;
    }

    /**
     * @return int
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * @return int[][]
     */
    public function getGrid()
    {
        return $this->grid;
    }

    /**
     * @param mixed $move One of the values in the Move pseudo-enum
     * @return Board
     */
    public function addMove($move)
    {
        $rotater = new GridRotater($move);

        $rotatedGrid = $rotater->rotateForMove($this->grid, $move);

        $calculatedGrid = array_map(function ($row) {
            $collapsedRow = $this->collapseRow($row);
            return $this->padRowWithEmptyCells($collapsedRow, count($this->grid));
        }, $rotatedGrid);

        $unrotatedGrid = $rotater->unrotateForMove($calculatedGrid, $move);

        return new Board($unrotatedGrid);
    }

    private function collapseRow($row)
    {
        if ($row === []) {
            return [];
        }

        if ($row[0] == Board::EMPTY_CELL) {
            return $this->collapseRow(array_slice($row, 1));
        }

        if (count($row) === 1) {
            return $row;
        }

        if ($row[0] == $row[1]) {
            $sum = $row[0] + $row[1];
            return array_merge([$sum], array_slice($row, 2));
        }

        return array_merge([$row[0]], $this->collapseRow(array_slice($row, 1)));
    }

    private function padRowWithEmptyCells($row, $size)
    {
        while (count($row) < $size) {
            array_push($row, Board::EMPTY_CELL);
        }

        return $row;
    }
}
