<?php

namespace Pinyin\Tests\Unit\PinyinRegex;

use PHPUnit\Framework\TestCase;
use Pinyin\PinyinRegex;

class PinyinRegexExtractFirstInitialTest extends TestCase
{
    /**
     * @dataProvider extractFirstInitialProvider
     *
     * @param string $input
     * @param string $expectedFirstInitial
     */
    public function testExtractFirstInitial(
        string $input,
        string $expectedFirstInitial
    ) {
        // Given an input string;

        // When we extract the first pinyin initial;
        $initial = PinyinRegex::extractFirstInitial($input);

        // Then we should get the best initial.
        self::assertSame(
            $expectedFirstInitial,
            $initial,
            sprintf(
                'First initial from "%s" should be "%s", got "%s"',
                $input,
                $expectedFirstInitial,
                $initial
            )
        );
    }

    /**
     * @return array[]
     */
    public function extractFirstInitialProvider(): array
    {
        return [
            ['', ''],
            ['a', ''],
            ['yu', ''],
            ['wu', ''],
            ['huan4', 'h'],
            ['hěi', 'h'],
            ['cheng0', 'ch'],
            ['miū', 'm'],
            ['shuai', 'sh'],
            ['ch', 'ch'],
            ['sh', 'sh'],
            ['b', 'b'],
            ['c', 'c'],
            ['zh', 'zh'],
            ['d', 'd'],
            ['f', 'f'],
            ['g', 'g'],
            ['h', 'h'],
            ['j', 'j'],
            ['k', 'k'],
            ['l', 'l'],
            ['m', 'm'],
            ['n', 'n'],
            ['p', 'p'],
            ['q', 'q'],
            ['r', 'r'],
            ['s', 's'],
            ['t', 't'],
            ['x', 'x'],
            ['z', 'z'],
        ];
    }
}
