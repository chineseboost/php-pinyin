<?php

namespace Pinyin\Hanzi;

use Pinyin\Hanzi\Conversion\FurthestForwardMatching;
use Pinyin\Hanzi\Conversion\HanziPinyinConversionStrategy;
use Pinyin\NonPinyinString;
use Pinyin\PinyinSentence;
use Pinyin\PinyinWord;
use Pinyin\String\Stringable;

class HanziSentence implements Stringable
{
    /** @var string */
    private $sentence;

    /** @var PinyinSentence */
    private $pinyin;

    /** @var HanziPinyinConversionStrategy */
    private $converter;

    /**
     * @param string                             $sentence
     * @param string|PinyinSentence              $pinyin
     * @param HanziPinyinConversionStrategy|null $converter
     */
    public function __construct(
        string $sentence = '',
        string $pinyin = '',
        HanziPinyinConversionStrategy $converter = null
    ) {
        $this->sentence = $sentence;

        if ($pinyin) {
            $this->pinyin = new PinyinSentence((string) $pinyin);
        }

        if (!$converter) {
            $converter = new FurthestForwardMatching();
        }
        $this->converter = $converter;
    }

    public function asPinyin(): PinyinSentence
    {
        if (!$this->pinyin) {
            $this->pinyin = $this->converter->convertHanziToPinyin($this->sentence);
        }
        return $this->pinyin;
    }

    /**
     * @return Stringable[]
     */
    public function elements(): array
    {
        $elements = [];
        $pos = 0;
        foreach ($this->asPinyin()->elements() as $pinyinElement) {
            if ($pinyinElement instanceof PinyinWord) {
                $charCount = count($pinyinElement->syllables());
                $elements[] = new HanziWord(
                    mb_substr($this->sentence, $pos, $charCount),
                    $pinyinElement->normalized(),
                    $this->converter
                );
                $pos += $charCount;
                continue;
            }
            if ($pinyinElement instanceof NonPinyinString) {
                if (trim($pinyinElement)) {
                    $charCount = mb_strlen($pinyinElement);
                    $elements[] = new NonHanziString(
                        mb_substr($this->sentence, $pos, $charCount)
                    );
                    $pos += $charCount;
                }
                continue;
            }
        }
        return $elements;
    }

    public function __toString(): string
    {
        return $this->sentence;
    }
}
