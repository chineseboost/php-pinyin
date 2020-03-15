<?php

namespace Pinyin;

use Pinyin\String\Normalizing;

class PinyinYear extends PinyinWord
{
    public const YEAR_PATTERN = <<<'REGEXP'
/\b[1-9]\d{1,3}\s*?ni[aá]n2?/iu
REGEXP;

    public const DIGIT_TABLE = [
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

    public static function replaceYears(string $input): string
    {
        return preg_replace_callback(
            static::YEAR_PATTERN,
            static function ($subject): string {
                return (string) (new static($subject[0]))->normalized();
            },
            $input
        );
    }

    public function normalized(): Normalizing
    {
        preg_match('/[1-9]\d{1,3}/u', $this->word, $matches);
        $normalized = $matches[0] ?? '';
        $normalized = preg_replace_callback(
            '/\d/u',
            static function ($subject): string {
                return ' '.static::DIGIT_TABLE[$subject[0]];
            },
            $normalized
        );
        $normalized = trim("{$normalized} nián");

        return new static($normalized);
    }
}
