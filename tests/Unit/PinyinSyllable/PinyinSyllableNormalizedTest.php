<?php

namespace Pinyin\Tests\Unit\PinyinSyllable;

use PHPUnit\Framework\TestCase;
use Pinyin\PinyinSyllable;

class PinyinSyllableNormalizedTest extends TestCase
{
    /**
     * @dataProvider normalizedProvider
     *
     * @param string $syllable
     * @param string $expectedNormalized
     */
    public function testNormalized(string $syllable, string $expectedNormalized)
    {
        // Given we have a pinyin syllable;
        $pinyinSyllable = new PinyinSyllable($syllable);

        // When we normalize it;
        $normalized = $pinyinSyllable->normalized();

        // Then it should be correctly normalized.
        self::assertSame(
            $expectedNormalized,
            (string) $normalized,
            sprintf(
                'Syllable "%s" should be "%s" when normalized, got "%s"',
                $syllable,
                $expectedNormalized,
                $normalized
            )
        );
    }

    /**
     * @return array[]
     */
    public function normalizedProvider(): array
    {
        return [
            ['', ''],
            ['a', 'a'],
            [' a  ', 'a'],
            [' a1  ', 'a1'],
            [' ā  ', 'ā'],
            ['lv', 'lü'],
            ['lü', 'lü'],
            ['lu', 'lu'],
            ['LV', 'Lü'],
            ['Biang3', 'Biang3'],
            [" \nnian3  ", 'nian3'],
            [" \tkao6  ", 'kao'],
            [' zui0 ', 'zui0'],
            [' meng5 ', 'meng5'],
            ['-_++==shen1^%', 'shen1'],
            ['wu2wei2', 'wu2'],
            ['Bei3jing1', 'Bei3'],
            ['Ā Q zhèng zhuàn', 'Ā'],
            ['zhèngzhuàn', 'zhèng'],
            ["Xī'ān", 'Xī']
        ];
    }
}
