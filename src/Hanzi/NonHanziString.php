<?php

namespace Pinyin\Hanzi;

use Pinyin\String\Stringable;

class NonHanziString implements Stringable
{
    /** @var string */
    private $string;

    /**
     * @param string $string
     */
    public function __construct(string $string)
    {
        $this->string = $string;
    }

    public function __toString(): string
    {
        return $this->string;
    }
}
