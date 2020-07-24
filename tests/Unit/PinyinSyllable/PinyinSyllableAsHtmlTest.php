<?php

namespace Pinyin\Tests\Unit\PinyinSyllable;

use PHPUnit\Framework\TestCase;
use Pinyin\PinyinSyllable;

class PinyinSyllableAsHtmlTest extends TestCase
{
    /**
     * @dataProvider asHtmlProvider
     *
     * @param string $syllable
     * @param string $expectedHtml
     */
    public function testAsHtml(string $syllable, string $expectedHtml): void
    {
        // Given we have a pinyin syllable;
        $pinyinSyllable = new PinyinSyllable($syllable);

        // When we get it as HTML;
        $html = $pinyinSyllable->asHtml();

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
                'qiān',
                '<span class="pinyin pinyin-syllable pinyin-tone-1"
lang="zh-Latn-CN-pinyin">qiān</span>',
            ],
            [
                'chá',
                '<span class="pinyin pinyin-syllable pinyin-tone-2"
lang="zh-Latn-CN-pinyin">chá</span>',
            ],
            [
                'gǔn',
                '<span class="pinyin pinyin-syllable pinyin-tone-3"
lang="zh-Latn-CN-pinyin">gǔn</span>',
            ],
            [
                'mà',
                '<span class="pinyin pinyin-syllable pinyin-tone-4"
lang="zh-Latn-CN-pinyin">mà</span>',
            ],
            [
                'me',
                '<span class="pinyin pinyin-syllable pinyin-tone-0"
lang="zh-Latn-CN-pinyin">me</span>',
            ],
        ];
    }
}
