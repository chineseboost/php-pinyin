<?php

namespace Pinyin\Hanzi;

use Normalizer;
use Pinyin\Hanzi\Conversion\FurthestForwardMatching;
use Pinyin\Hanzi\Conversion\HanziPinyinConversionStrategy;
use Pinyin\NonPinyinString;
use Pinyin\PinyinSyllable;
use Pinyin\PinyinWord;
use Pinyin\String\HtmlAble;
use Pinyin\String\Normalizing;
use Pinyin\String\PinyinAble;
use Pinyin\String\Stringable;

class HanziWord implements Normalizing, PinyinAble, HtmlAble
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

    public function asPinyin(): Stringable
    {
        if (!$this->pinyin) {
            $this->pinyin = new PinyinWord(
                (string) $this->converter->convertHanziToPinyin($this->word)
            );
        }

        return $this->pinyin;
    }

    /**
     * @return Normalizing[]
     */
    public function elements(): array
    {
        $elements = [];
        $pos = 0;
        $word = (string) $this->normalized();
        foreach ($this->asPinyin()->elements() as $pinyinElement) {
            if ($pinyinElement instanceof PinyinSyllable) {
                $elements[] = new HanziSyllable(
                    mb_substr($word, $pos, $pinyinElement->hanziCount()),
                    $pinyinElement,
                    $this->converter
                );
                $pos += $pinyinElement->hanziCount();
                continue;
            }
            if ($pinyinElement instanceof NonPinyinString) {
                if (trim($pinyinElement)) {
                    $charCount = mb_strlen($pinyinElement);
                    $elements[] = new NonHanziString(
                        mb_substr($word, $pos, $charCount)
                    );
                    $pos += $charCount;
                }
                continue;
            }
        }

        return $elements;
    }

    public function asHtml(string $lang = 'zh'): string
    {
        $elementsHtml = implode(
            '',
            array_map(
                static function (HtmlAble $element): string {
                    return $element->asHtml();
                },
                $this->elements()
            )
        );

        return trim(
            <<<HTML
<span class="hanzi word" lang="{$lang}">{$elementsHtml}</span>
HTML
        );
    }

    public function normalized(): Normalizing
    {
        mb_internal_encoding('UTF-8');

        return new self(Normalizer::normalize(trim($this->word)));
    }

    public function __toString(): string
    {
        return $this->word;
    }
}
