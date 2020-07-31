<?php

namespace Pinyin\Tests\Unit\Hanzi\HanziSyllable;

use PHPUnit\Framework\TestCase;
use Pinyin\Hanzi\HanziSyllable;

class HanziSyllableAsHtmlTest extends TestCase
{
    /**
     * @dataProvider asHtmlProvider
     *
     * @param string $syllable
     * @param string $expectedHtml
     */
    public function testAsHtml(string $syllable, string $expectedHtml): void
    {
        // Given we have a hanzi syllable;
        $hanziSyllable = new HanziSyllable($syllable);

        // When we get it as HTML;
        $html = $hanziSyllable->asHtml();

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
                '签',
                '<span class="hanzi syllable tone-1"
data-pinyin="qiān"
lang="zh">签</span>',
            ],
            [
                '茶',
                '<span class="hanzi syllable tone-2"
data-pinyin="chá"
lang="zh">茶</span>',
            ],
            [
                '滚',
                '<span class="hanzi syllable tone-3"
data-pinyin="gǔn"
lang="zh">滚</span>',
            ],
            [
                '骂',
                '<span class="hanzi syllable tone-4"
data-pinyin="mà"
lang="zh">骂</span>',
            ],
            [
                '了',
                '<span class="hanzi syllable tone-0"
data-pinyin="le"
lang="zh">了</span>',
            ],
            [
                '劲儿',
                '<span class="hanzi syllable tone-4"
data-pinyin="jìnr"
lang="zh">劲儿</span>',
            ],
        ];
    }
}
