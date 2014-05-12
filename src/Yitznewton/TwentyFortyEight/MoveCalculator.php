<?php

namespace Yitznewton\TwentyFortyEight;

class MoveCalculator
{
    private $grid;

    /**
     * @var MoveListener[]
     */
    private $moveListeners = [];

    /**
     * @param Grid $grid
     */
    public function __construct(Grid $grid)
    {
        $this->grid = $grid;
    }

    public function addListener(MoveListener $listener)
    {
        $this->moveListeners[] = $listener;
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
     * @param mixed $moveDirection
     * @return bool
     */
    public function isPossibleMove($moveDirection)
    {
        $move = new Move($this->grid, $moveDirection);
        return $move->execute() != $this->grid;
    }

    /**
     * @param mixed $moveDirection
     * @return array
     */
    public function makeMove($moveDirection)
    {
        $move = new Move($this->grid, $moveDirection, $this->moveListeners);
        return $move->execute();
    }
}
