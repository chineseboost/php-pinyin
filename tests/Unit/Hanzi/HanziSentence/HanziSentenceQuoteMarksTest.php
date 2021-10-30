<?php

namespace Pinyin\Tests\Unit\Hanzi\HanziSentence;

use PHPUnit\Framework\TestCase;
use Pinyin\Hanzi\HanziSentence;

class HanziSentenceQuoteMarksTest extends TestCase
{
    /**
     * @param string $sentence
     * @param string $expectedPinyin
     *
     * @dataProvider quoteMarkSpacingProvider
     */
    public function testQuoteMarkSpacing(string $sentence, string $expectedPinyin): void
    {
        // Given a hanzi sentence;
        $hanziSentence = new HanziSentence($sentence);

        // When we convert it to pinyin;
        $pinyin = $hanziSentence->asPinyin();

        // Then the spacing should be correct.
        self::assertEquals($expectedPinyin, (string) $pinyin);
    }

    /**
     * @return array[]
     */
    public static function quoteMarkSpacingProvider(): array
    {
        return [
            [
                '“还要咖啡吗？”“不了，谢谢。”',
                '“Hai2yao4 ka1fei1 ma5?” “Bu4le5, xie4xie5.”',
            ],
            [
                '"还要咖啡吗？""不了，谢谢。"',
                '"Hai2yao4 ka1fei1 ma5?" "Bu4le5, xie4xie5."',
            ],
        ];
    }
}
