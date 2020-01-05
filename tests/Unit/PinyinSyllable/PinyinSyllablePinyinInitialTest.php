<?php

namespace Pinyin\Tests\Unit\PinyinSyllable;

use PHPUnit\Framework\TestCase;
use Pinyin\PinyinInitial;
use Pinyin\PinyinSyllable;

class PinyinSyllablePinyinInitialTest extends TestCase
{
    /**
     * @dataProvider pinyinInitialProvider
     *
     * @param  string  $syllable
     * @param  string  $expectedInitial
     */
    public function testPinyinInitial(string $syllable, string $expectedInitial)
    {
        // Given a pinyin syllable;
        $pinyinSyllable = new PinyinSyllable($syllable);

        // When we get the initial;
        $initial = $pinyinSyllable->pinyinInitial();

        // Then we should get the correct initial.
        self::assertInstanceOf(PinyinInitial::class, $initial);
        self::assertSame(
            $expectedInitial,
            (string) $initial,
            sprintf(
                'Pinyin initial for "%s" should be "%s", got "%s"',
                $syllable,
                $expectedInitial,
                $initial
            )
        );
    }

    /**
     * @return array[]
     */
    public function pinyinInitialProvider(): array
    {
        return [
            ['a', ''],
            ['beng3', 'b'],
            ['duǎng', 'd'],
            ['dàn', 'd'],
            ['e', ''],
            ['han', 'h'],
            ['i', ''],
            ['o', ''],
            ['rēng', 'r'],
            ['v', ''],
            ['wu', ''],
            ['xie', 'x'],
            ['yu', ''],
            ['yuàn', ''],
            ['zuì', 'z'],
            ['zuī', 'z'],
            ['ü', ''],
        ];
    }
}
