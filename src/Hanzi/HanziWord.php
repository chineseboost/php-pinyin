<?php

namespace Pinyin\Hanzi;

use Pinyin\Hanzi\Conversion\FurthestForwardMatching;
use Pinyin\Hanzi\Conversion\HanziPinyinConversionStrategy;
use Pinyin\PinyinWord;
use Pinyin\String\Stringable;

class HanziWord implements Stringable
{
    /** @var string */
    private $word;

    /** @var PinyinWord */
    private $pinyin;

    /** @var HanziPinyinConversionStrategy */
    private $converter;

    /**
     * @param string                             $hanzi
     * @param string                             $pinyin
     * @param HanziPinyinConversionStrategy|null $converter
     */
    public function __construct(
        string $hanzi,
        string $pinyin = '',
        HanziPinyinConversionStrategy $converter = null
    ) {
        $this->word = $hanzi;

        if ($pinyin) {
            $this->pinyin = new PinyinWord($pinyin);
        }

        if (!$converter) {
            $converter = new FurthestForwardMatching();
        }
        $this->converter = $converter;
    }

    public function asPinyin(): PinyinWord
    {
        return $this->pinyin;
    }

    public function __toString(): string
    {
        return $this->word;
    }
}
