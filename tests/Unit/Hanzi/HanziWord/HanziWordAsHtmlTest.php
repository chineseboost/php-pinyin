<?php

namespace Pinyin\Tests\Unit\Hanzi\HanziWord;

use PHPUnit\Framework\TestCase;
use Pinyin\Hanzi\HanziWord;

class HanziWordAsHtmlTest extends TestCase
{
    /**
     * @dataProvider asHtmlProvider
     *
     * @param string $word
     * @param string $expectedHtml
     */
    public function testAsHtml(string $word, string $expectedHtml): void
    {
        // Given a hanzi word;
        $hanziWord = new HanziWord($word);

        // When we get it as HTML;
        $html = $hanziWord->asHtml();

        // Then we should get the expected HTML.
        self::assertSame($expectedHtml, $html);
    }

    /**
     * @return array[]
     */
    public function asHtmlProvider(): array
    {
        return [
            [
                '北京',
                '<span class="hanzi word" lang="zh"><span class="hanzi syllable tone-3"
data-pinyin="Běi"
lang="zh">北</span><span class="hanzi syllable tone-1"
data-pinyin="jīng"
lang="zh">京</span></span>',
            ],
            [
                '汉字',
                '<span class="hanzi word" lang="zh"><span class="hanzi syllable tone-4"
data-pinyin="Hàn"
lang="zh">汉</span><span class="hanzi syllable tone-4"
data-pinyin="zì"
lang="zh">字</span></span>',
            ],
            [
                '加速',
                '<span class="hanzi word" lang="zh"><span class="hanzi syllable tone-1"
data-pinyin="Jiā"
lang="zh">加</span><span class="hanzi syllable tone-4"
data-pinyin="sù"
lang="zh">速</span></span>',
            ],
            [
                '哥们儿',
                '<span class="hanzi word" lang="zh"><span class="hanzi syllable tone-1"
data-pinyin="Gē"
lang="zh">哥</span><span class="hanzi syllable tone-0"
data-pinyin="menr"
lang="zh">们儿</span></span>',
            ],
        ];
    }
}
