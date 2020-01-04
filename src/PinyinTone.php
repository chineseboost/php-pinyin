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

    const TONE_NUMBERS = [
        self::ZERO_FIFTH,
        self::FIRST,
        self::SECOND,
        self::THIRD,
        self::FOURTH
    ];

    const MARK_FIRST = 'ˉ';
    const MARK_SECOND = '´';
    const MARK_THIRD = 'ˇ';
    const MARK_FOURTH = '`';

    const TONE_MARKS = [
        self::ZERO_FIFTH => '',
        self::FIRST      => self::MARK_FIRST,
        self::SECOND     => self::MARK_SECOND,
        self::THIRD      => self::MARK_THIRD,
        self::FOURTH     => self::MARK_FOURTH,
    ];

    const VOWEL_MARKS = [
        'iu' => [
            self::ZERO_FIFTH => 'iu',
            self::FIRST      => 'iū',
            self::SECOND     => 'iú',
            self::THIRD      => 'iǔ',
            self::FOURTH     => 'iù',
        ],
        'a' => [
            self::ZERO_FIFTH => 'a',
            self::FIRST      => 'ā',
            self::SECOND     => 'á',
            self::THIRD      => 'ǎ',
            self::FOURTH     => 'à',
        ],
        'e' => [
            self::ZERO_FIFTH => 'e',
            self::FIRST      => 'ē',
            self::SECOND     => 'é',
            self::THIRD      => 'ě',
            self::FOURTH     => 'è',
        ],
        'i' => [
            self::ZERO_FIFTH => 'i',
            self::FIRST      => 'ī',
            self::SECOND     => 'í',
            self::THIRD      => 'ǐ',
            self::FOURTH     => 'ì',
        ],
        'o' => [
            self::ZERO_FIFTH => 'o',
            self::FIRST      => 'ō',
            self::SECOND     => 'ó',
            self::THIRD      => 'ǒ',
            self::FOURTH     => 'ò',
        ],
        'u' => [
            self::ZERO_FIFTH => 'u',
            self::FIRST      => 'ū',
            self::SECOND     => 'ú',
            self::THIRD      => 'ǔ',
            self::FOURTH     => 'ù',
        ],
        'ü' => [
            self::ZERO_FIFTH => 'ü',
            self::FIRST      => 'ǖ',
            self::SECOND     => 'ǘ',
            self::THIRD      => 'ǚ',
            self::FOURTH     => 'ǜ',
        ],
        'v' => [
            self::ZERO_FIFTH => 'v',
            self::FIRST      => 'v̄',
            self::SECOND     => 'v́',
            self::THIRD      => 'v̌',
            self::FOURTH     => 'v̀',
        ],
    ];

    const TONE_INDICATORS = [
        self::ZERO_FIFTH => ['5', '0', '·'],
        self::FIRST      => ['1', 'ā', 'ē', 'ī', 'ō', 'ū', 'ǖ', 'v̄', self::MARK_FIRST],
        self::SECOND     => ['2', 'á', 'é', 'í', 'ó', 'ú', 'ǘ', 'v́', self::MARK_SECOND],
        self::THIRD      => ['3', 'ǎ', 'ě', 'ǐ', 'ǒ', 'ǔ', 'ǚ', 'v̌', self::MARK_THIRD],
        self::FOURTH     => ['4', 'à', 'è', 'ì', 'ò', 'ù', 'ǜ', 'v̀', self::MARK_FOURTH],
    ];

    /**
     * @var int
     */
    private $toneNumber;

    /**
     * @param int $toneNumber
     */
    public function __construct(int $toneNumber)
    {
        $this->toneNumber = $toneNumber;
    }

    public static function fromPinyinSyllable(PinyinSyllable $syllable): self
    {
        return static::fromPinyinSyllableString((string) $syllable->normalized());
    }

    public static function fromPinyinSyllableString(string $syllable): self
    {
        return new static(static::determineTone($syllable));
    }

    public static function determineTone(string $syllable): int
    {
        $syllable = mb_strtolower(Normalizer::normalize($syllable));
        foreach (static::TONE_INDICATORS as $tone => $toneIndicators) {
            foreach ($toneIndicators as $toneIndicator) {
                if (mb_strpos($syllable, $toneIndicator) !== false) {
                    return $tone;
                }
            }
        }

        return static::ZERO_FIFTH;
    }

    public function number(): int
    {
        return $this->toneNumber;
    }

    public function isFirst(): bool
    {
        return $this->number() === static::FIRST;
    }

    public function isSecond(): bool
    {
        return $this->number() === static::SECOND;
    }

    public function isThird(): bool
    {
        return $this->number() === static::THIRD;
    }

    public function isFourth(): bool
    {
        return $this->number() === static::FOURTH;
    }

    public function isNeutral(): bool
    {
        return $this->number() === static::ZERO_FIFTH;
    }

    public function __toString()
    {
        return (string) $this->toneNumber;
    }
}
