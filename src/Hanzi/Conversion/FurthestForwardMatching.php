<?php

namespace Pinyin\Hanzi\Conversion;

use Pinyin\PinyinSentence;
use Pinyin\PinyinYear;

class FurthestForwardMatching implements HanziPinyinConversionStrategy
{
    /** @var array */
    private static $conversionTables = [];

    public function convertHanziToPinyin(string $hanzi): PinyinSentence
    {
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
            for ($i = mb_strlen($subject); $i >= 1; $i--) {
                $conversionTable = self::conversionTable($i);
                if (empty($conversionTable)) {
                    continue;
                }
                $furthestForward = mb_substr($subject, 0, $i);
                if (!isset($conversionTable[$furthestForward])) {
                    if ($i === 1) {
                        $pinyin .= mb_substr($subject, 0, 1);
                        $subject = mb_substr($subject, 1);
                    }
                    continue;
                }
                $pinyin .= " {$conversionTable[$furthestForward]} ";
                $subject = mb_substr($subject, $i);
                break;
            }
        }

        return trim($pinyin);
    }

    /**
     * @param int $hanziLength
     *
     * @return array
     */
    private static function conversionTable(int $hanziLength): array
    {
        $key = sprintf('%02d', $hanziLength);
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
