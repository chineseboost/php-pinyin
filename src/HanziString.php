<?php

namespace Pinyin;

class HanziString
{
    /**
     * @var HanziWord[]
     */
    private $words;

    /**
     * @param HanziWord[] $words
     */
    public function __construct(array $words)
    {
        $this->words = $words;
    }

    public function __toString()
    {
        return implode(
            '',
            array_map(
                function (HanziWord $word) {
                    return (string) $word;
                },
                $this->words
            )
        );
    }
}
