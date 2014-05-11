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
        return array_map(function ($row) {
            return $row->toArray();
        }, $this->rows);
    }

    public function count()
    {
        return count($this->rows);
    }

    public function map($callback)
    {
        return array_map($callback, $this->rows);
    }

    public function reduce($callback, $startingValue = null)
    {
        return array_reduce($this->flatten(), $callback, $startingValue);
    }

    public function contains($value)
    {
        return array_reduce($this->flatten(), function ($carry, $item) use ($value) {
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

        return self::fromArray($this->stack($flattened));
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
            $stacked[$i] = array_slice($flattened, $size*$i, $size);
        }

        return $stacked;
    }

    /**
     * @param array $array
     * @return self
     */
    public static function fromArray(array $array)
    {
        return new self(array_map(function ($row) {
            return new Collection($row);
        }, $array));
    }
}
