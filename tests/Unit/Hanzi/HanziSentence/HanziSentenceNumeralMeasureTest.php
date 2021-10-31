<?php

namespace Pinyin\Tests\Unit\Hanzi\HanziSentence;

use PHPUnit\Framework\TestCase;
use Pinyin\Hanzi\HanziSentence;

class HanziSentenceNumeralMeasureTest extends TestCase
{
    /**
     * @param string $sentence
     * @param string $expectedPinyin
     *
     * @dataProvider numeralMeasurePinyinProvider
     */
    public function testNumeralMeasurePinyin(
        string $sentence,
        string $expectedPinyin
    ): void {
        // Given a hanzi sentence containing numerals and a measure word;
        $hanziSentence = new HanziSentence($sentence);

        // When we convert it to pinyin;
        $pinyin = $hanziSentence->asPinyin();

        // Then we should get the correct pinyin.
        self::assertEquals($expectedPinyin, (string) $pinyin);
    }

    /**
     * @return array[]
     */
    public static function numeralMeasurePinyinProvider(): array
    {
        return [
            [
                '一亿三千两百万八千六百七十二个东西',
                'Yi1 yi4 san1 qian1 liang3 bai3 wan4 ba1 qian1 liu4 bai3 qi1 shi2 er4 ge5 dong1xi1',
            ],
            [
                '两百五十一个人',
                'Liang3 bai3 wu3 shi2 yi1 ge5 ren2',
            ],
        ];
    }
}
