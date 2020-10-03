<?php

namespace Pinyin\Hanzi\Conversion;

use Pinyin\PinyinSentence;
use Pinyin\PinyinYear;

class FurthestForwardMatching implements HanziPinyinConversionStrategy
{
    private const MAX_KEY_LENGTH = 13;

    /** @var array */
    private static $conversionTables = [];

    public function convertHanziToPinyin(string $hanzi): PinyinSentence
    {
        if (mb_strlen($hanzi) >= 3) {
            foreach (self::conversionTable('tweaks') as $regex => $replacement) {
                $hanzi = preg_replace($regex, $replacement, $hanzi);
            }
        }

        $pinyin = implode(
            ' ',
            array_map(
                static function (string $section): string {
                    return self::furthestForwardMatching($section);
                },
                preg_split(
                    '/([^\p{Han}]+)/u',
                    $hanzi,
                    -1,
                    PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY
                )
            )
        );

        $pinyin = trim($pinyin);
        $pinyin = preg_replace('/\s+/u', ' ', $pinyin);
        $pinyin = preg_replace('/\s([,!?.:)])/u', '$1', $pinyin);
        $pinyin = preg_replace('/([(])\s/u', '$1', $pinyin);
        $pinyin = PinyinYear::replaceYears($pinyin);
        $firstChar = mb_strtoupper(mb_substr($pinyin, 0, 1));
        $rest = mb_substr($pinyin, 1);

        return new PinyinSentence("{$firstChar}{$rest}");
    }

    private static function furthestForwardMatching(string $subject): string
    {
        $pinyin = '';

        while ($subject !== '') {
            for ($pos = min(mb_strlen($subject), self::MAX_KEY_LENGTH); $pos >= 1; $pos--) {
                $conversionTable = self::conversionTable(sprintf('%02d', $pos));
                if (empty($conversionTable)) {
                    continue;
                }
                $furthestForward = mb_substr($subject, 0, $pos);
                if (!isset($conversionTable[$furthestForward])) {
                    if ($pos === 1) {
                        $pinyin .= mb_substr($subject, 0, 1);
                        $subject = mb_substr($subject, 1);
                    }
                    continue;
                }
                if ($pos === 1 && $pinyin && ($furthestForward === '儿' || $furthestForward === '兒')) {
                    $pinyin = preg_replace('/([0-5]?)\s*$/u', 'r$1 ', $pinyin, 1);
                    $subject = mb_substr($subject, 1);
                    break;
                }
                $pinyin .= " {$conversionTable[$furthestForward]} ";
                $subject = mb_substr($subject, $pos);
                break;
            }
        }

        return trim($pinyin);
    }

    /**
     * @param string $key
     *
     * @return array
     */
    private static function conversionTable(string $key): array
    {
        if (!isset(self::$conversionTables[$key])) {
            self::$conversionTables[$key] = self::loadConversionTable($key);
        }

        return self::$conversionTables[$key];
    }

    private static function loadConversionTable(string $key): array
    {
        $filePath = self::conversionTablePath($key);
        if (!is_file($filePath)) {
            return [];
        }

        /** @noinspection PhpIncludeInspection */
        return require $filePath;
    }

    private static function conversionTablePath(string $key): string
    {
        return implode(
            DIRECTORY_SEPARATOR,
            [__DIR__, '..', '..', '..', 'data', "{$key}_pinyin.data"]
        );
    }
}
