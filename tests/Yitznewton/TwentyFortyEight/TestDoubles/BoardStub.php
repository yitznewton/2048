<?php

namespace Yitznewton\TwentyFortyEight\TestDoubles;

use Yitznewton\TwentyFortyEight\Board;

class BoardStub implements Board
{
    private $grid;

    /**
     * @param array $grid
     */
    public function __construct(array $grid)
    {
        $this->grid = $grid;
    }

    /**
     * @return int
     */
    public function getScore()
    {
        return 105678;
    }

    /**
     * @return array
     */
    public function getGrid()
    {
        return $this->grid;
    }

    public function initialize()
    {
        throw new \BadMethodCallException('initialize() not implemented');
    }

    public function hasPossibleMoves()
    {
        throw new \BadMethodCallException('hasPossibleMoves() not implemented');
    }

    public function addMove($move)
    {
        $move; // PHPMD
        throw new \BadMethodCallException('addMove() not implemented');
    }
}
