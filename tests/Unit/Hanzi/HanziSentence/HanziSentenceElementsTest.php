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
        foreach ($expectedElements as $idx => $expectedElement) {
            self::assertSame(
                (string) $expectedElement,
                (string) ($elements[$idx]),
                sprintf(
                    '#%d word of "%s" should be "%s", got "%s" ("%s")',
                    $idx,
                    $sentence,
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
            [
                '',
                [],
            ],
            [
                '我要去北京了。',
                ['我', '要', '去', '北京', '了', '。'],
            ],
            [
                '我不要去北京，我要去上海。',
                ['我', '不要', '去', '北京', '，', '我', '要', '去', '上海', '。'],
            ],
            [
                '当年的商业发展为当今的唐人街奠定了基础。',
                ['当年', '的', '商业', '发展', '为', '当今', '的', '唐人', '街', '奠定', '了', '基础', '。'],
            ],
            [
                '如果你喝速溶咖啡，就不需要咖啡壶了。',
                ['如果', '你', '喝', '速溶', '咖啡', '，', '就', '不', '需要', '咖啡', '壶', '了', '。'],
            ],
            [
                '“还要咖啡吗？”“不了，谢谢。”',
                ['“','还要','咖啡','吗','？”','“','不了','，','谢谢','。”'],
            ]
        ];
    }
}
