<?php

namespace Pinyin;

use Normalizer;

class PinyinTone
{
    const ZERO_FIFTH = 0;
    const FIRST = 1;
    const SECOND = 2;
    const THIRD = 3;
    const FOURTH = 4;

    const TONE_INDICATORS = [
        PinyinTone::FIRST      => ['1', 'ā', 'ē', 'ī', 'ō', 'ū', 'ǖ', 'v̄', 'ˉ'],
        PinyinTone::SECOND     => ['2', 'á', 'é', 'í', 'ó', 'ú', 'ǘ', 'v́', '´'],
        PinyinTone::THIRD      => ['3', 'ǎ', 'ě', 'ǐ', 'ǒ', 'ǔ', 'ǚ', 'v̌', 'ˇ'],
        PinyinTone::FOURTH     => ['4', 'à', 'è', 'ì', 'ò', 'ù', 'ǜ', 'v̀', '`'],
        PinyinTone::ZERO_FIFTH => ['5', '0'],
    ];

    /** @var int */
    private $toneNumber;

    /**
     * @param int $toneNumber
     */
    public function __construct(int $toneNumber)
    {
        $this->toneNumber = $toneNumber;
    }

    public static function fromPinyinSyllable(PinyinSyllable $syllable): PinyinTone
    {
        return static::fromPinyinSyllableString((string) $syllable);
    }

    public static function fromPinyinSyllableString(string $syllable): PinyinTone
    {
        return new static(static::determineTone($syllable));
    }

    public static function determineTone(string $syllable): int
    {
        $syllable = Normalizer::normalize($syllable);
        foreach (static::TONE_INDICATORS as $tone => $toneIndicators) {
            foreach ($toneIndicators as $toneIndicator) {
                if (mb_strpos($syllable, $toneIndicator) !== false) {
                    return $tone;
                }
            }
        }

        return static::ZERO_FIFTH;
    }

    public function toneNumber(): int
    {
        return $this->toneNumber;
    }

    public function isFirst(): bool
    {
        return $this->toneNumber() === static::FIRST;
    }

    public function isSecond(): bool
    {
        return $this->toneNumber() === static::SECOND;
    }

    public function isThird(): bool
    {
        return $this->toneNumber() === static::THIRD;
    }

    public function isFourth(): bool
    {
        return $this->toneNumber() === static::FOURTH;
    }

    public function isNeutral(): bool
    {
        return $this->toneNumber() === static::ZERO_FIFTH;
    }

    public function __toString()
    {
        return (string) $this->toneNumber;
    }
}
