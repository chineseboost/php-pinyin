<?php

namespace Pinyin\Tests\Unit\PinyinSentence;

use PHPUnit\Framework\TestCase;
use Pinyin\PinyinSentence;

class PinyinSentenceElementsTest extends TestCase
{
    /**
     * @dataProvider elementsProvider
     *
     * @param string $sentence
     * @param array  $expectedElements
     */
    public function testElements(string $sentence, array $expectedElements): void
    {
        // Given we have a pinyin sentence;
        $pinyinSentence = new PinyinSentence($sentence);

        // When we get its component elements;
        $elements = $pinyinSentence->elements();

        // Then we should get the correct elements.
        self::assertCount(
            count($expectedElements),
            $elements,
            sprintf(
                '"%s" should have %d elements ("%s"), got %d ("%s")',
                $sentence,
                count($expectedElements),
                implode('","', $expectedElements),
                count($elements),
                implode('","', $elements)
            )
        );
        foreach ($expectedElements as $i => $expectedElement) {
            self::assertSame(
                (string) $expectedElement,
                (string) ($elements[$i]),
                sprintf(
                    '#%d word of "%s" should be "%s", got "%s" ("%s")',
                    $i,
                    $sentence,
                    $expectedElement,
                    $elements[$i],
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
            ['Wo3 yao4 qu4 Bei3jing1 le', ['Wo3', 'yao4', 'qu4', 'Bei3jing1', 'le']],
            ['Wo3yao4qu4Bei3jing1le', ['Wo3yao4qu4', 'Bei3jing1le']],
        ];
    }
}
