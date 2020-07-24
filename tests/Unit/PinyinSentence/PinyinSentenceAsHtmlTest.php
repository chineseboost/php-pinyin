<?php

namespace Pinyin\Tests\Unit\PinyinSentence;

use PHPUnit\Framework\TestCase;
use Pinyin\PinyinSentence;

class PinyinSentenceAsHtmlTest extends TestCase
{
    /**
     * @dataProvider asHtmlProvider
     *
     * @param string $sentence
     * @param string $expectedHtml
     */
    public function testAsHtml(string $sentence, string $expectedHtml): void
    {
        // Given we have a pinyin sentence;
        $pinyinSentence = new PinyinSentence($sentence);

        // When we get it as HTML;
        $html = $pinyinSentence->asHtml();

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
                'Sān rén xíng, bì yǒu wǒ shī.',
                '<span class="pinyin pinyin-sentence" lang="zh-Latn-CN-pinyin"><span class="pinyin pinyin-word" lang="zh-Latn-CN-pinyin"><span class="pinyin pinyin-syllable pinyin-tone-1"
lang="zh-Latn-CN-pinyin">Sān</span></span> <span class="non-pinyin"> </span> <span class="pinyin pinyin-word" lang="zh-Latn-CN-pinyin"><span class="pinyin pinyin-syllable pinyin-tone-2"
lang="zh-Latn-CN-pinyin">rén</span></span> <span class="non-pinyin"> </span> <span class="pinyin pinyin-word" lang="zh-Latn-CN-pinyin"><span class="pinyin pinyin-syllable pinyin-tone-2"
lang="zh-Latn-CN-pinyin">xíng</span></span> <span class="non-pinyin">,</span> <span class="non-pinyin"> </span> <span class="pinyin pinyin-word" lang="zh-Latn-CN-pinyin"><span class="pinyin pinyin-syllable pinyin-tone-4"
lang="zh-Latn-CN-pinyin">bì</span></span> <span class="non-pinyin"> </span> <span class="pinyin pinyin-word" lang="zh-Latn-CN-pinyin"><span class="pinyin pinyin-syllable pinyin-tone-3"
lang="zh-Latn-CN-pinyin">yǒu</span></span> <span class="non-pinyin"> </span> <span class="pinyin pinyin-word" lang="zh-Latn-CN-pinyin"><span class="pinyin pinyin-syllable pinyin-tone-3"
lang="zh-Latn-CN-pinyin">wǒ</span></span> <span class="non-pinyin"> </span> <span class="pinyin pinyin-word" lang="zh-Latn-CN-pinyin"><span class="pinyin pinyin-syllable pinyin-tone-1"
lang="zh-Latn-CN-pinyin">shī</span></span> <span class="non-pinyin">.</span></span>'
            ],
            [
                'Wǒ míngtiān chūfā.',
                '<span class="pinyin pinyin-sentence" lang="zh-Latn-CN-pinyin"><span class="pinyin pinyin-word" lang="zh-Latn-CN-pinyin"><span class="pinyin pinyin-syllable pinyin-tone-3"
lang="zh-Latn-CN-pinyin">Wǒ</span></span> <span class="non-pinyin"> </span> <span class="pinyin pinyin-word" lang="zh-Latn-CN-pinyin"><span class="pinyin pinyin-syllable pinyin-tone-2"
lang="zh-Latn-CN-pinyin">míng</span><span class="pinyin pinyin-syllable pinyin-tone-1"
lang="zh-Latn-CN-pinyin">tiān</span></span> <span class="non-pinyin"> </span> <span class="pinyin pinyin-word" lang="zh-Latn-CN-pinyin"><span class="pinyin pinyin-syllable pinyin-tone-1"
lang="zh-Latn-CN-pinyin">chū</span><span class="pinyin pinyin-syllable pinyin-tone-1"
lang="zh-Latn-CN-pinyin">fā</span></span> <span class="non-pinyin">.</span></span>'
            ],
        ];
    }
}
