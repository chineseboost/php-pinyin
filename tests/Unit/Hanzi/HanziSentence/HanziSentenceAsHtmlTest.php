<?php

namespace Pinyin\Tests\Unit\Hanzi\HanziSentence;

use PHPUnit\Framework\TestCase;
use Pinyin\Hanzi\HanziSentence;

class HanziSentenceAsHtmlTest extends TestCase
{
    /**
     * @dataProvider asHtmlProvider
     *
     * @param string $sentence
     * @param string $expectedHtml
     */
    public function testAsHtml(string $sentence, string $expectedHtml): void
    {
        // Given we have a hanzi sentence;
        $hanziSentence = new HanziSentence($sentence);

        // When we get it as HTML;
        $html = $hanziSentence->asHtml();

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
                '学而时习之，不亦说乎？',
                '<span class="hanzi sentence" lang="zh"><span class="hanzi word" lang="zh"><span class="hanzi syllable tone-2"
data-pinyin="Xué"
lang="zh">学</span></span><span class="hanzi word" lang="zh"><span class="hanzi syllable tone-2"
data-pinyin="ér"
lang="zh">而</span></span><span class="hanzi word" lang="zh"><span class="hanzi syllable tone-2"
data-pinyin="shí"
lang="zh">时</span></span><span class="hanzi word" lang="zh"><span class="hanzi syllable tone-2"
data-pinyin="xí"
lang="zh">习</span></span><span class="hanzi word" lang="zh"><span class="hanzi syllable tone-1"
data-pinyin="zhī"
lang="zh">之</span></span><span class="non-hanzi">，</span><span class="hanzi word" lang="zh"><span class="hanzi syllable tone-4"
data-pinyin="bù"
lang="zh">不</span></span><span class="hanzi word" lang="zh"><span class="hanzi syllable tone-4"
data-pinyin="yì"
lang="zh">亦</span></span><span class="hanzi word" lang="zh"><span class="hanzi syllable tone-4"
data-pinyin="yuè"
lang="zh">说</span></span><span class="hanzi word" lang="zh"><span class="hanzi syllable tone-1"
data-pinyin="hū"
lang="zh">乎</span></span><span class="non-hanzi">？</span></span>',
            ],
            [
                '我明天出发。',
                '<span class="hanzi sentence" lang="zh"><span class="hanzi word" lang="zh"><span class="hanzi syllable tone-3"
data-pinyin="Wǒ"
lang="zh">我</span></span><span class="hanzi word" lang="zh"><span class="hanzi syllable tone-2"
data-pinyin="míng"
lang="zh">明</span><span class="hanzi syllable tone-1"
data-pinyin="tiān"
lang="zh">天</span></span><span class="hanzi word" lang="zh"><span class="hanzi syllable tone-1"
data-pinyin="chū"
lang="zh">出</span><span class="hanzi syllable tone-1"
data-pinyin="fā"
lang="zh">发</span></span><span class="non-hanzi">。</span></span>',
            ],
        ];
    }
}
