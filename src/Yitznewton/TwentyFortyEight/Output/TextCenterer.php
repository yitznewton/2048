<?php

namespace Yitznewton\TwentyFortyEight\Output;

class TextCenterer
{
    const RESOLVE_LEFT = 1;
    const RESOLVE_RIGHT = 2;

    private $resolutionRule;

    /**
     * @param int $resolutionRule
     */
    public function __construct($resolutionRule = self::RESOLVE_LEFT)
    {
        $this->validateResolutionRule($resolutionRule);
        $this->resolutionRule = $resolutionRule;
    }

    /**
     * @param string $text
     * @param int $cellWidth
     * @throws \UnexpectedValueException
     * @return string
     */
    public function centerText($text, $cellWidth)
    {
        if ($cellWidth < 1) {
            throw new \UnexpectedValueException('Cell width must be a positive integer');
        }

        if ($cellWidth < strlen($text)) {
            throw new \UnexpectedValueException('Cell width must be at least the length of the text');
        }

        $initialSpaceCount = $this->initialSpaceCount($text, $cellWidth);
        $initialSpaces = str_repeat(' ', $initialSpaceCount);

        $closingSpaceCount = $cellWidth - $initialSpaceCount - strlen($text);
        $closingSpaces = str_repeat(' ', $closingSpaceCount);

        return $initialSpaces . $text . $closingSpaces;
    }

    /**
     * @param $text
     * @param $cellWidth
     * @return float
     */
    private function initialSpaceCount($text, $cellWidth)
    {
        $method = $this->roundingFunction();
        return $method(($cellWidth - strlen($text)) / 2);
    }

    /**
     * @throws \UnexpectedValueException
     * @return string
     */
    private function roundingFunction()
    {
        switch ($this->resolutionRule) {
            case self::RESOLVE_LEFT:
                return 'floor';
            case self::RESOLVE_RIGHT:
                return 'ceil';
        }
    }

    private function validateResolutionRule($rule)
    {
        if (!in_array($rule, [self::RESOLVE_LEFT, self::RESOLVE_RIGHT])) {
            throw new \UnexpectedValueException('Unknown resolution rule: ' . $rule);
        }
    }
}
