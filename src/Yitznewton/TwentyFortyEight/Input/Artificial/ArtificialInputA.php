<?php

namespace Yitznewton\TwentyFortyEight\Input\Artificial;

use Yitznewton\TwentyFortyEight\Grid;
use Yitznewton\TwentyFortyEight\Input\Input;
use Yitznewton\TwentyFortyEight\Move\Move;
use Yitznewton\TwentyFortyEight\Move\MoveMaker;
use Yitznewton\TwentyFortyEight\Move\Scorer;

class ArtificialInputA implements Input
{
    const MAX_MOVES_TO_TRY = 1;

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
        $movesWithScores = $this->getMovesWithScores($this->grid);
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
            return ['nothing' => 0];
        }

        $moveMaker = new MoveMaker($grid);
        $possibleMoves = $moveMaker->getPossibleMoves();

        $moveScores = array_map(function ($move) use ($grid) {
            $moveMaker = new MoveMaker($grid);
            $scorer = new Scorer();
            $moveMaker->addListener($scorer);

            $newGrid = $moveMaker->makeMove($move);
            return $scorer->getScore();
        }, $possibleMoves);

        $movesWithScores = array_combine($possibleMoves, $moveScores);
        return $movesWithScores;
    }

    private function highScoreMoves($movesWithScores)
    {
        arsort($movesWithScores);
        $highScore = array_values($movesWithScores)[0];
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
}
