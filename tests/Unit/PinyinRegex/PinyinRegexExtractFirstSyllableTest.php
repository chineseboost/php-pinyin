<?php

namespace Pinyin\Tests\Unit\PinyinRegex;

use PHPUnit\Framework\TestCase;
use Pinyin\PinyinRegex;

class PinyinRegexExtractFirstSyllableTest extends TestCase
{
    /**
     * @dataProvider extractFirstSyllableProvider
     *
     * @param string $haystack
     * @param string $expectedFirstSyllable
     */
    public function testExtractFirstSyllable(string $haystack, string $expectedFirstSyllable): void
    {
        // Given an input string;

        // When we extract the first pinyin syllable;
        $firstSyllable = PinyinRegex::extractFirstSyllable($haystack);

        // Then we should get the best first syllable.
        self::assertSame(
            $expectedFirstSyllable,
            $firstSyllable,
            sprintf(
                'First syllable in "%s" should be "%s", got "%s"',
                $haystack,
                $expectedFirstSyllable,
                $firstSyllable
            )
        );
    }

    /**
     * @return array[]
     */
    public function extractFirstSyllableProvider(): array
    {
        return [
            ['', ''],
            ['a', 'a'],
            [' a  ', 'a'],
            [' a1  ', 'a1'],
            [' ā  ', 'ā'],
            ['gbei3a', 'bei3'],
            [" \nnian3  ", 'nian3'],
            [" \tkao6  ", 'kao'],
            [' zui0 ', 'zui0'],
            [' meng5 ', 'meng5'],
            ['-_++==shen1^%', 'shen1'],
            ['wu2wei2', 'wu2'],
            ['Bei3jing1', 'Bei3'],
            ['Ā Q zhèng zhuàn', 'Ā'],
            ['zhèngzhuàn', 'zhèng'],
            ["Xī'ān", 'Xī'],
            ['xue', 'xue'],
        ];
    }
}
