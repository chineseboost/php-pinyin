<?php

namespace Pinyin\Tests\Unit\PinyinWord;

use PHPUnit\Framework\TestCase;
use Pinyin\PinyinWord;

class PinyinWordElementsTest extends TestCase
{
    /**
     * @dataProvider elementsProvider
     *
     * @param string   $word
     * @param string[] $expectedElements
     */
    public function testElements(string $word, array $expectedElements): void
    {
        // Given a pinyin word;
        $pinyinWord = new PinyinWord($word);

        // When we get the pinyin elements;
        $elements = $pinyinWord->elements();

        // Then we should get the correct elements.
        self::assertCount(
            count($expectedElements),
            $elements,
            sprintf(
                "'%s' should have %d elements ('%s'), got %d ('%s')",
                $word,
                count($expectedElements),
                implode("','", $expectedElements),
                count($elements),
                implode("','", $elements)
            )
        );
        foreach ($expectedElements as $idx => $expectedElement) {
            self::assertSame(
                (string) $expectedElement,
                (string) ($elements[$idx]),
                sprintf(
                    "#%d syllable of '%s' should be '%s', got '%s'",
                    $idx,
                    $word,
                    $expectedElement,
                    $elements[$idx]
                )
            );
        }
    }

    public function elementsProvider(): array
    {
        return [
            ['Qing1dao3', ['Qing1', 'dao3']],
            ['Bei3 jing1', ['Bei3', ' ', 'jing1']],
            ['erhua', ['er', 'hua']],
            ['daor', ['daor']],
            ['wēnxīn', ['wēn', 'xīn']],
            ['Zhōngguó Rénmín Gònghéguó', ['Zhōng', 'guó', ' ', 'Rén', 'mín', ' ', 'Gòng', 'hé', 'guó']],
            ['2020nian2', ['er4', ' ', 'ling2', ' ', 'er4', ' ', 'ling2', ' ', 'nian2']],
            ['bu2dao4100', ['bu2', 'dao4', '100']],
        ];
    }
}
