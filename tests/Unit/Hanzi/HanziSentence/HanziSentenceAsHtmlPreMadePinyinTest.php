<?php

namespace Pinyin\Tests\Unit\Hanzi\HanziSentence;

use PHPUnit\Framework\TestCase;
use Pinyin\Hanzi\HanziSentence;

class HanziSentenceAsHtmlPreMadePinyinTest extends TestCase
{
    /**
     * @dataProvider asHtmlPreMadePinyinProvider
     *
     * @param string $sentence
     * @param string $pinyin
     * @param string $expectedHtml
     */
    public function testAsHtml(
        string $sentence,
        string $pinyin,
        string $expectedHtml
    ): void {
        // Given we have a hanzi sentence with pre-made pinyin;
        $hanziSentence = new HanziSentence($sentence, $pinyin);

        // When we get it as HTML;
        $html = $hanziSentence->asHtml();

        // Then we should get the expected HTML.
        self::assertSame($expectedHtml, $html);
    }

    /**
     * @return array[]
     */
    public function asHtmlPreMadePinyinProvider(): array
    {
        return [
            [
                '喝速溶咖啡。',
                'Hē sùróngkāfēi.',
                '<span class="hanzi sentence" lang="zh"><span class="hanzi word" lang="zh"><span class="hanzi syllable tone-1"
data-pinyin="Hē"
lang="zh">喝</span></span><span class="hanzi word" lang="zh"><span class="hanzi syllable tone-4"
data-pinyin="sù"
lang="zh">速</span><span class="hanzi syllable tone-2"
data-pinyin="róng"
lang="zh">溶</span><span class="hanzi syllable tone-1"
data-pinyin="kā"
lang="zh">咖</span><span class="hanzi syllable tone-1"
data-pinyin="fēi"
lang="zh">啡</span></span><span class="non-hanzi">。</span></span>',
            ],
            [
                '唐人街',
                'Tángrén Jiē',
                '<span class="hanzi sentence" lang="zh"><span class="hanzi word" lang="zh"><span class="hanzi syllable tone-2"
data-pinyin="Táng"
lang="zh">唐</span><span class="hanzi syllable tone-2"
data-pinyin="rén"
lang="zh">人</span></span><span class="hanzi word" lang="zh"><span class="hanzi syllable tone-1"
data-pinyin="Jiē"
lang="zh">街</span></span></span>',
            ],
        ];
    }
}
