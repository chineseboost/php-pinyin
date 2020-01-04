<?php

namespace Pinyin\Tests\Unit\PinyinSyllable;

use PHPUnit\Framework\TestCase;
use Pinyin\PinyinSyllable;
use Pinyin\PinyinTone;

class PinyinSyllableToneTest extends TestCase
{
    /**
     * @dataProvider toneProvider
     *
     * @param string $syllable
     * @param int    $expectedToneNumber
     */
    public function testTone(string $syllable, int $expectedToneNumber)
    {
        // Given we have a pinyin syllable;
        $syllable = new PinyinSyllable($syllable);

        // When we get the tone;
        $tone = $syllable->tone();

        // Then we should get the correct tone.
        self::assertInstanceOf(PinyinTone::class, $tone);
        self::assertSame($expectedToneNumber, $tone->number());
        self::assertSame((string) $expectedToneNumber, (string) $tone);
    }

    public function toneProvider(): array
    {
        return [
            ['', 0],
            ['b', 0],
            ['ma', 0],
            ['wā', 1],
            ['xí', 2],
            ['sǎo', 3],
            ['càng', 4],
        ];
    }
}
