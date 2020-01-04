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
    public function __construct($syllable)
    {
        $this->syllable = Normalizer::normalize($syllable);
    }

    public function tone(): PinyinTone
    {
        if (!$this->tone) {
            $this->tone = PinyinTone::fromPinyinSyllable($this);
        }

        return $this->tone;
    }
}
