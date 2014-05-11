<?php

namespace Yitznewton\TwentyFortyEight;

class GridRotater
{
    /**
     * @param Grid $grid
     * @param mixed $move
     * @return array
     */
    public function rotateForMove(Grid $grid, $move)
    {
        return $this->rotate($grid, $this->rotationsForMove($move));
    }

    /**
     * @param Grid $grid
     * @param $move
     * @return array
     */
    public function unrotateForMove(Grid $grid, $move)
    {
        return $this->rotate($grid, $this->unrotationsForMove($move));
    }

    /**
     * @param Grid $grid
     * @param int $numberOfRotations
     * @return array
     */
    public function rotate(Grid $grid, $numberOfRotations)
    {
        if ($numberOfRotations == 0) {
            return $grid;
        }

        $grid = $grid->toArray();

        $flipped = [];

        for ($i = 0; $i < count($grid); $i++) {
            for ($j = 0; $j < count($grid); $j++) {
                $flipped[$i][$j] = $grid[$j][$i];
            }
        }

        $rotated = array_map('array_reverse', $flipped);

        return $this->rotate(Grid::fromArray($rotated), $numberOfRotations-1);
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

    private function unrotationsForMove($move)
    {
        $totalMoves = count(Move::getAll());
        // add on an extra $totalMoves to avoid division by zero
        return $totalMoves * 2 % ($this->rotationsForMove($move) + $totalMoves);
    }
}
