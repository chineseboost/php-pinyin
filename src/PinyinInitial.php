<?php

namespace Pinyin;

/**
 * https://en.wikipedia.org/wiki/Pinyin#Initials.
 */
class PinyinInitial
{
    const INITIALS = [
        'ch',
        'sh',
        'zh',
        'b',
        'c',
        'd',
        'f',
        'g',
        'h',
        'j',
        'k',
        'l',
        'm',
        'n',
        'p',
        'q',
        'r',
        's',
        't',
        'x',
        'z',
    ];

    const ORTHOGRAPHICS = [
        'y',
        'w',
    ];

    /** @var string */
    private $initial;

    /**
     * PinyinInitial constructor.
     *
     * @param string $initial
     */
    public function __construct(string $initial)
    {
        $this->initial = trim($initial);
    }

    public function exists(): bool
    {
        return mb_strlen($this->initial) > 0;
    }

    public function isEmpty(): bool
    {
        return !$this->exists();
    }

    public function __toString()
    {
        return $this->initial;
    }
}
