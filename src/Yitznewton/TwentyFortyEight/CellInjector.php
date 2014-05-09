<?php

namespace Yitznewton\TwentyFortyEight;

class CellInjector
{
    /**
     * @param array $grid
     * @return array
     */
    public function injectInto(array $grid)
    {
        $randomChoices = [2,4];
        $randomNumber = $randomChoices[rand(0, 1)];
        return $this->injectIntoRandomEmptyCell($grid, $randomNumber);
    }

    private function injectIntoRandomEmptyCell($grid, $number)
    {
        $flattened = $this->flatten($grid);

        $emptyIndexes = [];

        foreach ($flattened as $index => $value) {
            if ($value == EMPTY_CELL) {
                $emptyIndexes[] = $index;
            }
        }

        if (!$emptyIndexes) {
            return $grid;
        }

        $chosenIndex = $emptyIndexes[array_rand($emptyIndexes)];
        $flattened[$chosenIndex] = $number;

        return $this->stack($flattened);
    }

    private function flatten(array $grid)
    {
        return array_reduce($grid, function ($carry, $row) {
            return array_merge($carry, $row);
        }, []);
    }

    private function stack(array $flattened)
    {
        $size = sqrt(count($flattened));

        $stacked = [];

        for ($i = 0; $i < $size; $i++) {
            $stacked[$i] = array_slice($flattened, $size*$i, $size);
        }

        return $stacked;
    }
}
