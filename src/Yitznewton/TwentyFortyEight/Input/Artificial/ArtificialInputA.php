<?php

namespace Yitznewton\TwentyFortyEight\Input\Artificial;

use Yitznewton\TwentyFortyEight\Grid;
use Yitznewton\TwentyFortyEight\Input\Input;
use Yitznewton\TwentyFortyEight\Move\Move;
use Yitznewton\TwentyFortyEight\Move\MoveMaker;
use Yitznewton\TwentyFortyEight\Move\Scorer;

class ArtificialInputA implements Input
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
     * @return mixed
     */
    public function getMove()
    {
        $moveMaker = new MoveMaker($this->grid);
        $possibleMoves = $moveMaker->getPossibleMoves();

        $moveScores = array_map(function ($move) {
            $moveMaker = new MoveMaker($this->grid);
            $scorer = new Scorer();
            $moveMaker->addListener($scorer);

            $moveMaker->makeMove($move);
            return $scorer->getScore();
        }, $possibleMoves);

        $movesWithScores = array_combine($possibleMoves, $moveScores);
        arsort($movesWithScores);

        return $this->preferredMove($this->highScoreMoves($movesWithScores));
    }

    private function preferredMove($possibleMoves)
    {
        $peckingOrder = [
            Move::UP,
            Move::LEFT,
            Move::RIGHT,
            Move::DOWN,
        ];

        return array_reduce($peckingOrder, function ($carry, $move) use ($possibleMoves) {
            if ($carry) {
                return $carry;
            }

            if (in_array($move, $possibleMoves)) {
                return $move;
            }

            return null;
        });
    }

    private function highScoreMoves($movesWithScores)
    {
        $highScore = array_values($movesWithScores)[0];
        return array_keys($movesWithScores, $highScore);
    }
}
