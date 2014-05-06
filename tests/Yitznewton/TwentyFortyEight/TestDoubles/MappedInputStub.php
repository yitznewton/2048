<?php

namespace Yitznewton\TwentyFortyEight\TestDoubles;

use Yitznewton\TwentyFortyEight\Input\MappedInput;

class MappedInputStub extends MappedInput
{
    private $char;

    /**
     * @param string $char
     */
    public function setChar($char)
    {
        $this->char = $char;
    }

    /**
     * @return mixed
     */
    protected function getCharFromDevice()
    {
        return $this->char;
    }
}
