<?php

namespace Pinyin\Tests\Unit\Hanzi\HanziSentence;

use PHPUnit\Framework\TestCase;
use Pinyin\Hanzi\HanziSentence;

class HanziSentenceElementsTest extends TestCase
{
    /**
     * @dataProvider elementsProvider
     *
     * @param string $sentence
     * @param array  $expectedElements
     */
    public function testElements(string $sentence, array $expectedElements): void
    {
        // Given we have a hanzi sentence;
        $hanziSentence = new HanziSentence($sentence);

        // When we get its component elements;
        $elements = $hanziSentence->elements();

        // Then we should get the correct elements.
        self::assertCount(
            count($expectedElements),
            $elements,
            sprintf(
                "'%s' should have %d elements ('%s'), got %d ('%s')",
                $sentence,
                count($expectedElements),
                implode("','", $expectedElements),
                count($elements),
                implode("','", $elements)
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
            [
                '',
                [],
            ],
            [
                '我要去北京了。',
                ['我', '要', '去', '北京', '了', '。']
            ],
            [
                '我不要去北京，我要去上海。',
                ['我', '不要', '去', '北京', '，', '我', '要', '去', '上海', '。']
            ],
        ];
    }
}
