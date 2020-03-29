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
        $pinyin = '';

        while ($hanzi !== '') {
            for ($i = mb_strlen($hanzi); $i >= 1; $i--) {
                $conversionTable = self::conversionTable($i);
                if (empty($conversionTable)) {
                    continue;
                }
                $furthestForward = mb_substr($hanzi, 0, $i);
                if (!isset($conversionTable[$furthestForward])) {
                    if ($i === 1) {
                        $pinyin .= mb_substr($hanzi, 0, 1);
                        $hanzi = mb_substr($hanzi, 1);
                    }
                    continue;
                }
                $pinyin .= " {$conversionTable[$furthestForward]} ";
                $hanzi = mb_substr($hanzi, $i);
                break;
            }
        }

        $pinyin = trim($pinyin);
        $pinyin = preg_replace('/\s+/u', ' ', $pinyin);
        $pinyin = preg_replace('/\s([,!?.:)])/u', '$1', $pinyin);
        $pinyin = preg_replace('/([(])\s/u', '$1', $pinyin);
        $pinyin = PinyinYear::replaceYears($pinyin);
        $firstChar = mb_strtoupper(mb_substr($pinyin, 0, 1));
        $rest = mb_substr($pinyin, 1);
        return new PinyinSentence("{$firstChar}{$rest}");
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
            [__DIR__, '..', '..', '..', 'data', "{$key}_pinyin.php"]
        );
    }
}
