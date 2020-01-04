<?php

namespace Pinyin;

use Normalizer;

class PinyinSyllable
{
    /** @var string */
    private $syllable;

    /** @var PinyinTone */
    private $tone;

    /**
     * @param string $syllable
     */
    public function __construct(string $syllable)
    {
        $this->syllable = Normalizer::normalize($syllable);
    }

    /**
     * @return PinyinTone
     */
    public function tone(): PinyinTone
    {
        if (!$this->tone) {
            $this->tone = PinyinTone::fromPinyinSyllable($this);
        }

        return $this->tone;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->syllable;
    }
}
