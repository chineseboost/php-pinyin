<?php

namespace Pinyin;

use Pinyin\String\Normalizing;

class PinyinYear extends PinyinWord
{
    public const YEAR_PATTERN = <<<'REGEXP'
/\b[1-9]\d{1,3}\s*?ni[aá]n2?/iu
REGEXP;

    public const DECADE_PATTERN = <<<'REGEXP'
/\b[1-9]\d\s*?h[oò]u4?/iu
REGEXP;

    public const DIGIT_TABLE_TONE_MARKED = [
        '0' => 'líng',
        '1' => 'yī',
        '2' => 'èr',
        '3' => 'sān',
        '4' => 'sì',
        '5' => 'wǔ',
        '6' => 'liù',
        '7' => 'qī',
        '8' => 'bā',
        '9' => 'jiǔ',
    ];

    public const DIGIT_TABLE_TONE_NUMBERED = [
        '0' => 'ling2',
        '1' => 'yi1',
        '2' => 'er4',
        '3' => 'san1',
        '4' => 'si4',
        '5' => 'wu3',
        '6' => 'liu4',
        '7' => 'qi1',
        '8' => 'ba1',
        '9' => 'jiu3',
    ];

    public static function replaceYears(string $input): string
    {
        $yearsReplaced = preg_replace_callback(
            static::YEAR_PATTERN,
            static function ($subject): string {
                return (string) (new static($subject[0]))->normalized();
            },
            $input
        );
        return preg_replace_callback(
            static::DECADE_PATTERN,
            static function ($subject): string {
                return (string) (new static($subject[0]))->normalized();
            },
            $yearsReplaced
        );
    }

    public function normalized(): Normalizing
    {
        $toneMarked = PinyinTone::isToneMarked($this->word);

        $table = static::DIGIT_TABLE_TONE_NUMBERED;
        if ($toneMarked) {
            $table = static::DIGIT_TABLE_TONE_MARKED;
        }

        preg_match('/[1-9]\d{1,3}/u', $this->word, $matches);
        $normalized = $matches[0] ?? '';
        $normalized = preg_replace_callback(
            '/\d/u',
            static function ($subject) use ($table): string {
                return ' '.$table[$subject[0]];
            },
            $normalized
        );

        $suffix = '';
        if (preg_match(static::YEAR_PATTERN, $this->word) === 1) {
            $suffix = $toneMarked ? 'nián' : 'nian2';
        } elseif (preg_match(static::DECADE_PATTERN, $this->word) === 1) {
            $suffix = $toneMarked ? 'hòu' : 'hou4';
        }

        return new static(trim("{$normalized} {$suffix}"));
    }
}
