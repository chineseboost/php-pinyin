<?php

namespace Pinyin;

use Normalizer;
use Pinyin\String\Normalizing;

class NonPinyinString implements Normalizing
{
    /** @var string */
    private $string;

    /**
     * @param  string  $string
     */
    public function __construct(string $string)
    {
        $this->string = $string;
    }

    public function normalized(): Normalizing
    {
        return new static(preg_replace('/\s+/ug', ' ', Normalizer::normalize($this->string)));
    }

    public function __toString(): string
    {
        return $this->string;
    }
}
