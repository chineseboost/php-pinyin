<?php

namespace Pinyin;

class HanziWord
{
    /**
     * @var Hanzi[]
     */
    private $hanzi;

    /**
     * @param Hanzi[] $hanzi
     */
    public function __construct(array $hanzi)
    {
        $this->hanzi = $hanzi;
    }

    public function __toString()
    {
        return implode(
            '',
            array_map(
                function (Hanzi $hanzi) {
                    return (string) $hanzi;
                },
                $this->hanzi
            )
        );
    }
}
