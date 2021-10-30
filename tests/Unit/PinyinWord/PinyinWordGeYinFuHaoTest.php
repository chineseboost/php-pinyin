<?php

namespace Pinyin\Tests\Unit\PinyinWord;

use PHPUnit\Framework\TestCase;
use Pinyin\PinyinWord;

/**
 * Test 隔音符号 / 隔音符號 / géyīn fúhào / syllable-dividing mark / apostrophe.
 */
class PinyinWordGeYinFuHaoTest extends TestCase
{
    /**
     * @param string $word
     * @param string $expectedToneMarked
     *
     * @dataProvider geYinFuHaoToneMarkedProvider
     */
    public function testGeYinFuHaoToneMarked(
        string $word,
        string $expectedToneMarked
    ): void {
        // Given a pinyin word that might need a 隔音符号;
        $pinyinWord = new PinyinWord($word);

        // When we get it tone-marked;
        $toneMarked = $pinyinWord->toneMarked();

        // Then we should get the correct tone marking with a 隔音符号.
        self::assertSame($expectedToneMarked, (string) $toneMarked);
    }

    /**
     * @return array[]
     */
    public static function geYinFuHaoToneMarkedProvider(): array
    {
        return [
            ['Xi1an1', "Xī'ān"],
            ['Tian1e2', "Tiān'é"],
            ['Bi3an4', "Bǐ'àn"],
            ['Di4er4', "Dì'èr"],
        ];
    }
}
