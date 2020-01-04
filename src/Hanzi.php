<?php

namespace Pinyin;

use InvalidArgumentException;

class Hanzi
{
    /**
     * @var string
     */
    private $hanzi;

    /**
     * @param string $hanzi
     */
    public function __construct($hanzi)
    {
        if (mb_strlen($hanzi) !== 1) {
            throw new InvalidArgumentException(
                "Hanzi must be a single character, given ${hanzi}"
            );
        }
        $this->hanzi = $hanzi;
    }

    public function __toString()
    {
        return $this->hanzi;
    }
}
