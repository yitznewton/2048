<?php

namespace Yitznewton\TwentyFortyEight\Tests\Input;

use Yitznewton\TwentyFortyEight\Move;
use Yitznewton\TwentyFortyEight\TestDoubles\MappedInputStub;

class MappedInputTest extends \PHPUnit_Framework_TestCase
{
    private static $keyMap = [
        'w' => Move::UP,
        'a' => Move::LEFT,
        's' => Move::DOWN,
        'd' => Move::RIGHT,
    ];

    private $input;

    public function setUp()
    {
        parent::setUp();
        $this->input = new MappedInputStub(self::$keyMap);
    }

    /**
     * @return array
     */
    public function getKeyMappings()
    {
        $mappings = [];

        foreach (self::$keyMap as $key => $move) {
            $mappings[] = [$key, $move];
        }

        return $mappings;
    }

    /**
     * @return array
     */
    public function getUndefinedKeyMappings()
    {
        return [
            ['t', 'i', chr(1),]
        ];
    }

    /**
     * @dataProvider getKeyMappings
     */
    public function testGetInputWhenMappingExists($key, $move)
    {
        $this->input->setChar($key);
        $this->assertEquals($move, $this->input->getMove());
    }

    /**
     * @dataProvider getUndefinedKeyMappings
     */
    public function testGetInputWhenMappingDoesNotExist($key)
    {
        $this->input->setChar($key);

        $this->setExpectedException(\UnexpectedValueException::class);
        $this->input->getMove();
    }
}
