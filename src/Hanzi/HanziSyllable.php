<?php

namespace Pinyin\Hanzi;

use InvalidArgumentException;
use Normalizer;
use Pinyin\Hanzi\Conversion\FurthestForwardMatching;
use Pinyin\Hanzi\Conversion\HanziPinyinConversionStrategy;
use Pinyin\PinyinSyllable;
use Pinyin\PinyinTone;
use Pinyin\String\HtmlAble;
use Pinyin\String\Normalizing;
use Pinyin\String\PinyinAble;
use Pinyin\String\Stringable;

class HanziSyllable implements Normalizing, PinyinAble, HtmlAble
{
    /** @var string */
    private $syllable;

    /** @var PinyinSyllable */
    private $pinyin;

    /** @var HanziPinyinConversionStrategy */
    private $converter;

    /**
     * @param string                             $syllable
     * @param string                             $pinyin
     * @param HanziPinyinConversionStrategy|null $converter
     */
    public function __construct(
        string $syllable,
        string $pinyin = '',
        HanziPinyinConversionStrategy $converter = null
    ) {
        mb_internal_encoding('UTF-8');
        $length = mb_strlen($syllable);
        switch ($length) {
            case 2:
                $second = mb_substr($syllable, -1);
                if ($second !== '儿' && $second !== '兒') {
                    throw new InvalidArgumentException(
                        "Hanzi syllable must be a single character or end with 儿/兒; given ${syllable}"
                    );
                }
                $this->syllable = $syllable;
                break;
            case 1:
                $this->syllable = $syllable;
                break;
            default:
                throw new InvalidArgumentException(
                    "Hanzi syllable must be a single character or end with 儿/兒; given ${syllable}"
                );
        }

        if ($pinyin) {
            $this->pinyin = new PinyinSyllable($pinyin);
        }

        if (!$converter) {
            $converter = new FurthestForwardMatching();
        }
        $this->converter = $converter;
    }

    public function tone(): PinyinTone
    {
        return $this->asPinyin()->tone();
    }

    /**
     * @return PinyinSyllable
     */
    public function asPinyin(): Stringable
    {
        if (!$this->pinyin) {
            $this->pinyin = new PinyinSyllable(
                mb_strtolower(
                    $this->converter->convertHanziToPinyin($this->syllable)
                )
            );
        }
        return $this->pinyin;
    }

    public function normalized(): Normalizing
    {
        mb_internal_encoding('UTF-8');

        return new self(Normalizer::normalize(trim($this->syllable)));
    }

    public function asHtml(string $lang = 'zh'): string
    {
        return trim(
            <<<HTML
<span class="hanzi syllable tone-{$this->tone()->number()}"
data-pinyin="{$this->asPinyin()->toneMarked()}"
lang="{$lang}">{$this->normalized()}</span>
HTML
        );
    }

    public function __toString(): string
    {
        return $this->syllable;
    }
}
