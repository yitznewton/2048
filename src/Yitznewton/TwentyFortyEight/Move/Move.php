<?php

namespace Yitznewton\TwentyFortyEight\Move;

use Yitznewton\TwentyFortyEight\Collection;
use Yitznewton\TwentyFortyEight\Grid;

class Move
{
    const UP = 1;
    const DOWN = 2;
    const LEFT = 3;
    const RIGHT = 4;

    private $grid;
    private $direction;
    private $moveListeners;

    public function __construct(Grid $grid, $direction, $moveListeners = [])
    {
        $this->grid = $grid;
        $this->direction = $direction;
        $this->moveListeners = $moveListeners;
    }

    public function execute()
    {
        $rotater = new GridRotater($this->direction);

        $rotatedGrid = $rotater->rotateForMove($this->grid, $this->direction);

        $calculatedGrid = Grid::fromArray($rotatedGrid->map(function ($row) {
            return $this->collapseAndPadRow($row);
        }));

        return $rotater->unrotateForMove($calculatedGrid, $this->direction);
    }

    private function collapseAndPadRow($row)
    {
        $collapsedRow = $this->collapseRow($row);
        return $this->padRowWithEmptyCells($collapsedRow, count($row));
    }

    private function collapseRow(Collection $row)
    {
        $row = $row->delete(Grid::EMPTY_CELL);

        if (count($row) < 2) {
            return $row;
        }

        if ($row->index(0) == $row->index(1)) {
            $this->registerCollapseEvent($row->slice(0,2));
            $sum = $row->index(0) * 2;
            $newFirst = new Collection([$sum]);
            return $newFirst->merge($this->collapseRow($row->slice(2)));
        }

        $newFirst = $row->slice(0,1);
        return $newFirst->merge($this->collapseRow($row->slice(1)));
    }

    private function padRowWithEmptyCells(Collection $row, $size)
    {
        while (count($row) < $size) {
            $row = $row->append(Grid::EMPTY_CELL);
        }

        return $row->toArray();
    }

    private function registerCollapseEvent($cells)
    {
        array_map(function ($listener) use ($cells) {
            $listener->addCollapseEvent($cells->toArray());
        }, $this->moveListeners);
    }

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
