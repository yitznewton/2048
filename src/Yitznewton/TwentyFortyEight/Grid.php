<?php

namespace Yitznewton\TwentyFortyEight;

class Grid
{
    private $rows;

    /**
     * @param Collection[] $rows
     */
    private function __construct(array $rows)
    {
        $this->rows = $rows;
    }

    public function toArray()
    {
        return $this->rows;
    }

    public function reduce($callback, $startingValue = null)
    {
        return array_reduce($this->flatten(), $callback, $startingValue);
    }

    public function contains($value)
    {
        return $this->reduce(function ($carry, $item) use ($value) {
            return $carry || $item == $value;
        }, false);
    }

    public function replaceRandom($target, $replace)
    {
        $flattened = $this->flatten();
        $targetIndexes = [];

        foreach ($flattened as $index => $value) {
            if ($value == $target) {
                $targetIndexes[] = $index;
            }
        }

        if (!$targetIndexes) {
            return $this;
        }

        $indexToReplace = $targetIndexes[array_rand($targetIndexes)];
        $flattened[$indexToReplace] = $replace;

        return $this->stack($flattened);
    }

    private function flatten()
    {
        return array_reduce($this->rows, function ($carry, $row) {
            return array_merge($carry, $row->toArray());
        }, []);
    }

    private function stack($flattened)
    {
        $size = count($this->rows);
        $stacked = [];

        for ($i = 0; $i < $size; $i++) {
            $stacked[$i] = new Collection(array_slice($flattened, $size*$i, $size));
        }

        return new self($stacked);
    }

    public static function createFilled($size, $fillValue)
    {
        return new Grid(array_map(function () use ($size, $fillValue) {
            return new Collection(array_fill(0, $size, $fillValue));
        }, range(0, $size-1)));
    }
}
