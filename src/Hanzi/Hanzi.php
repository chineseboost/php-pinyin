<?php

namespace Pinyin\Hanzi;

use InvalidArgumentException;
use Pinyin\String\Stringable;

class Hanzi implements Stringable
{
    /**
     * @var string
     */
    private $hanzi;

    /**
     * @param string $hanzi
     */
    public function __construct(string $hanzi)
    {
        mb_internal_encoding('UTF-8');
        if (mb_strlen($hanzi) !== 1) {
            throw new InvalidArgumentException(
                "Hanzi must be a single character, given ${hanzi}"
            );
        }
        $this->hanzi = $hanzi;
    }

    public function __toString(): string
    {
        return $this->hanzi;
    }
}
