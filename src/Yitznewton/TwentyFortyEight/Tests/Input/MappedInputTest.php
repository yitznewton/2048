<?php

namespace Yitznewton\TwentyFortyEight\Tests\Input;

use Yitznewton\TwentyFortyEight\Grid;
use Yitznewton\TwentyFortyEight\Input\MappedInput;
use Yitznewton\TwentyFortyEight\Input\UnrecognizedInputException;
use Yitznewton\TwentyFortyEight\Move\Move;
use Yitznewton\TwentyFortyEight\Tests\Doubles\Input\Device\CharacterInputStub;

class MappedInputTest extends \PHPUnit_Framework_TestCase
{
    private static $keyMap = [
        'w' => Move::UP,
        'a' => Move::LEFT,
        's' => Move::DOWN,
        'd' => Move::RIGHT,
    ];

    private $input;
    private $device;

    public function setUp()
    {
        parent::setUp();
        $this->device = new CharacterInputStub();
        $this->input = new MappedInput(self::$keyMap, $this->device);
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
            ['t'],
            ['i'],
            [chr(1)],
        ];
    }

    /**
     * @dataProvider getKeyMappings
     */
    public function testGetInputWhenMappingExists($key, $move)
    {
        $this->device->setChar($key);
        $this->assertEquals($move, $this->input->getMove(Grid::fromArray([])));
    }

    /**
     * @dataProvider getUndefinedKeyMappings
     */
    public function testGetInputWhenMappingDoesNotExist($key)
    {
        $this->device->setChar($key);

        $this->setExpectedException(UnrecognizedInputException::class);
        $this->input->getMove(Grid::fromArray([]));
    }
}
