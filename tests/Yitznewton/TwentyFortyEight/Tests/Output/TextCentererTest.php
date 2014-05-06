<?php

namespace Yitznewton\TwentyFortyEight\Tests\Output;

use Yitznewton\TwentyFortyEight\Output\TextCenterer;

class TextCentererTest extends \PHPUnit_Framework_TestCase
{
    public function getTextForResolveLeft()
    {
        return [
            ['a', 1, 'a'],
            ['a', 2, 'a '],
            ['a', 3, ' a '],
            ['a', 4, ' a  '],
        ];
    }

    public function getTextForResolveRight()
    {
        return [
            ['a', 1, 'a'],
            ['a', 2, ' a'],
            ['a', 3, ' a '],
            ['a', 4, '  a '],
        ];
    }

    public function getTextForUnexpected()
    {
        return [
            ['a', 0],
            ['a', -1],
            ['aaaa', 3],
        ];
    }

    /**
     * @dataProvider getTextForResolveLeft
     * @param string $text
     * @param int $cellWidth
     * @param string $expectedOutput
     */
    public function testCenterTextWithResolveLeft($text, $cellWidth, $expectedOutput)
    {
        $centerer = new TextCenterer(TextCenterer::RESOLVE_LEFT);
        $this->assertEquals($expectedOutput, $centerer->centerText($text, $cellWidth));
    }

    /**
     * @dataProvider getTextForResolveRight
     * @param string $text
     * @param int $cellWidth
     * @param string $expectedOutput
     */
    public function testCenterTextWithResolveRight($text, $cellWidth, $expectedOutput)
    {
        $centerer = new TextCenterer(TextCenterer::RESOLVE_RIGHT);
        $this->assertEquals($expectedOutput, $centerer->centerText($text, $cellWidth));
    }

    /**
     * @dataProvider getTextForUnexpected
     * @param string $text
     * @param int $cellWidth
     */
    public function testCenterTextWithUnexpected($text, $cellWidth)
    {
        $centerer = new TextCenterer();
        $this->setExpectedException(\UnexpectedValueException::class);
        $centerer->centerText($text, $cellWidth);
    }

    public function testBadResolutionRule()
    {
        $this->setExpectedException(\UnexpectedValueException::class);
        new TextCenterer(998);
    }
}
