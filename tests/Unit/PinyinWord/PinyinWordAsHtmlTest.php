<?php

namespace Pinyin\Tests\Unit\PinyinWord;

use PHPUnit\Framework\TestCase;
use Pinyin\PinyinWord;

class PinyinWordAsHtmlTest extends TestCase
{
    /**
     * @dataProvider asHtmlProvider
     *
     * @param string $word
     * @param string $expectedHtml
     */
    public function testAsHtml(string $word, string $expectedHtml): void
    {
        // Given a pinyin word;
        $pinyinWord = new PinyinWord($word);

        // When we get it as HTML;
        $html = $pinyinWord->asHtml();

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
                'Běijīng',
                '<span class="pinyin pinyin-word" lang="zh-Latn-CN-pinyin"><span class="pinyin pinyin-syllable pinyin-tone-3"
lang="zh-Latn-CN-pinyin">Běi</span><span class="pinyin pinyin-syllable pinyin-tone-1"
lang="zh-Latn-CN-pinyin">jīng</span></span>'
            ],
            [
                'hànzì',
                '<span class="pinyin pinyin-word" lang="zh-Latn-CN-pinyin"><span class="pinyin pinyin-syllable pinyin-tone-4"
lang="zh-Latn-CN-pinyin">hàn</span><span class="pinyin pinyin-syllable pinyin-tone-4"
lang="zh-Latn-CN-pinyin">zì</span></span>'
            ],
            [
                'jiāsù',
                '<span class="pinyin pinyin-word" lang="zh-Latn-CN-pinyin"><span class="pinyin pinyin-syllable pinyin-tone-1"
lang="zh-Latn-CN-pinyin">jiā</span><span class="pinyin pinyin-syllable pinyin-tone-4"
lang="zh-Latn-CN-pinyin">sù</span></span>'
            ],
        ];
    }
}
