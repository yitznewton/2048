<?php

namespace Yitznewton\TwentyFortyEight\Input\Artificial;

use Yitznewton\TwentyFortyEight\Grid;
use Yitznewton\TwentyFortyEight\Input\Input;
use Yitznewton\TwentyFortyEight\Move\Move;
use Yitznewton\TwentyFortyEight\Move\MoveMaker;
use Yitznewton\TwentyFortyEight\Move\Scorer;

class ArtificialInputA implements Input
{
    const MAX_MOVES_TO_TRY = 2;

    /**
     * @param Grid $grid
     * @return mixed
     */
    public function getMove(Grid $grid)
    {
        $movesWithScores = $this->getMovesWithScores($grid);
        return $this->preferredMove($this->highScoreMoves($movesWithScores));
    }

    /**
     * @param Grid $grid
     * @param int $leftToTry
     * @return array
     */
    private function getMovesWithScores(Grid $grid, $leftToTry = self::MAX_MOVES_TO_TRY)
    {
        if ($leftToTry == 0) {
            return [];
        }

        $moveMaker = new MoveMaker($grid);
        $possibleMoves = $moveMaker->getPossibleMoves();

        $moveScores = array_map(function ($move) use ($grid, $leftToTry) {
            $moveMaker = new MoveMaker($grid);
            $scorer = new Scorer();
            $moveMaker->addListener($scorer);

            $newGrid = $moveMaker->makeMove($move);
            $bestSubsequentMove = $this->max($this->getMovesWithScores($newGrid, $leftToTry-1));
            return $scorer->getScore() + $bestSubsequentMove;
        }, $possibleMoves);

        $movesWithScores = array_combine($possibleMoves, $moveScores);
        return $movesWithScores;
    }

    private function highScoreMoves($movesWithScores)
    {
        $highScore = $this->max($movesWithScores);
        return array_keys($movesWithScores, $highScore);
    }

    private function preferredMove($possibleMoves)
    {
        $peckingOrder = [
            Move::UP,
            Move::LEFT,
            Move::RIGHT,
            Move::DOWN,
        ];

        return array_values(array_intersect($peckingOrder, $possibleMoves))[0];
    }

    /**
     * @param array $array
     * @return int
     */
    private function max(array $array)
    {
        if (empty($array)) {
            return 0;
        }

        return max($array);
    }
}
