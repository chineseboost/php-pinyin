<?php

namespace Pinyin\Tests\Unit\PinyinWord;

use PHPUnit\Framework\TestCase;
use Pinyin\PinyinWord;

class PinyinWordToneMarkedTest extends TestCase
{
    /**
     * @dataProvider toneMarkedProvider
     *
     * @param string $pinyin
     * @param string $expectedToneMarked
     */
    public function testToneMarked(string $pinyin, string $expectedToneMarked): void
    {
        // Given a pinyin word;
        $pinyinWord = new PinyinWord($pinyin);

        // When we get it tone-marked;
        $toneMarked = $pinyinWord->toneMarked();

        // Then we should get the correct tone marking.
        self::assertSame($expectedToneMarked, (string) $toneMarked);
    }

    /**
     * @return array[]
     */
    public function toneMarkedProvider(): array
    {
        return [
            ['Ni3hao3', 'Nǐhǎo'],
            ['Bei3jing1 Wai4guo2yu3 Da4xue2', 'Běijīng Wàiguóyǔ Dàxué'],
            ['Běijing1 Wàiguóyǔ Da4xué', 'Běijīng Wàiguóyǔ Dàxué'],
            ['zhong1hua2ren2min2gong4he2guo2', 'zhōnghuárénmíngònghéguó'],
            ['yi1 ge', 'yī ge'],
            ['yi1dianr3', 'yīdiǎnr'],
        ];
    }
}
