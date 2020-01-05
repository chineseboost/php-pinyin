<?php

namespace Pinyin\Tests\Unit\PinyinTone;

use PHPUnit\Framework\TestCase;
use Pinyin\PinyinTone;

class PinyinToneApplyToneMarkTest extends TestCase
{
    /**
     * @dataProvider applyToneMarkProvider
     *
     * @param string $input
     * @param int    $toneNumber
     * @param string $expectedToneMarked
     */
    public function testApplyToneMark(
        string $input,
        int $toneNumber,
        string $expectedToneMarked
    ) {
        // Given an input string;

        // When we apply a tone mark to it;
        $toneMarked = PinyinTone::applyToneMark($input, $toneNumber);

        // Then it should be best-effort tone-marked.
        self::assertSame(
            $expectedToneMarked,
            $toneMarked,
            sprintf(
                '"%s" with tone %d should be tone-marked as "%s", got "%s"',
                $input,
                $toneNumber,
                $expectedToneMarked,
                $toneMarked
            )
        );
    }

    /**
     * @return array[]
     */
    public function applyToneMarkProvider(): array
    {
        return [
            ['xuan', 0, 'xuan'],
            ['zu', 1, 'zū'],
            ['sen', 2, 'sén'],
            ['mang', 3, 'mǎng'],
            ['she', 4, 'shè'],
            ['zhui', 5, 'zhui'],
            ['biao', 0, 'biao'],
            ['a', 1, 'ā'],
            ['e', 2, 'é'],
            ['i', 3, 'ǐ'],
            ['o', 4, 'ò'],
            ['u', 5, 'u'],
            ['v', 1, 'v̄'],
            ['xiu', 2, 'xiú'],
            ['üan', 3, 'üǎn'],
            ['', 3, ''],
        ];
    }
}
