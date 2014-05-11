<?php

namespace Yitznewton\TwentyFortyEight;

class Collection
{
    private $array;

    /**
     * @param $array
     */
    public function __construct($array)
    {
        $this->array = $array;
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->array);
    }

    /**
     * @param $item
     * @return self
     */
    public function append($item)
    {
        $newArray = $this->array;
        array_push($newArray, $item);
        return new self($newArray);
    }

    /**
     * @param int $start
     * @param int $for
     * @return self
     */
    public function slice($start, $for = null)
    {
        return new self(array_slice($this->array, $start, $for));
    }

    /**
     * @param Collection $arrayToMerge
     * @return self
     */
    public function merge(Collection $arrayToMerge)
    {
        return new self(array_merge($this->array, $arrayToMerge->toArray()));
    }

    /**
     * @param int $index
     * @throws \OutOfRangeException
     * @return mixed
     */
    public function index($index)
    {
        if (!array_key_exists($index, $this->array)) {
            throw new \OutOfRangeException();
        }

        return $this->array[$index];
    }

    public function delete($toDelete)
    {
        return new Collection(array_values(array_filter(array_map(function ($item) use ($toDelete) {
            return $item == $toDelete ? null : $item;
        }, $this->array))));
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->array;
    }
}
