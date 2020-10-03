<?php

namespace Pinyin\Tests\Unit\Hanzi\HanziWord;

use PHPUnit\Framework\TestCase;
use Pinyin\Hanzi\HanziWord;

class HanziWordElementsTest extends TestCase
{
    /**
     * @dataProvider elementsProvider
     *
     * @param string $word
     * @param array  $expectedElements
     */
    public function testElements(string $word, array $expectedElements): void
    {
        // Given we have a hanzi word;
        $hanziWord = new HanziWord($word);

        // When we get its component elements;
        $elements = $hanziWord->elements();

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
                    '#%d word of "%s" should be "%s", got "%s" ("%s")',
                    $idx,
                    $word,
                    $expectedElement,
                    $elements[$idx],
                    implode('","', $elements)
                )
            );
        }
    }

    /**
     * @return array[]
     */
    public function elementsProvider(): array
    {
        return [
            ['', []],
            ['你好', ['你', '好']],
            ['哥们儿', ['哥', '们儿']],
            ['哥們兒', ['哥', '們兒']],
            ['1998年', ['1', '9', '9', '8', '年']],
        ];
    }
}
