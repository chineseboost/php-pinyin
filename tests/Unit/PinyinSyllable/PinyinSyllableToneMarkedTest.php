<?php

namespace Pinyin\Tests\Unit\PinyinSyllable;

use PHPUnit\Framework\TestCase;
use Pinyin\PinyinSyllable;

class PinyinSyllableToneMarkedTest extends TestCase
{
    /**
     * @dataProvider toneMarkedProvider
     *
     * @param string $syllable
     * @param string $expectedToneMarked
     */
    public function testToneMarked(string $syllable, string $expectedToneMarked): void
    {
        // Given we have a pinyin syllable;
        $pinyinSyllable = new PinyinSyllable($syllable);

        // When we get it tone-marked;
        $toneMarked = $pinyinSyllable->toneMarked();

        // Then it should be correctly tone-marked;
        self::assertSame(
            $expectedToneMarked,
            (string) $toneMarked,
            sprintf(
                'Syllable "%s" should be "%s" when tone-marked, got "%s"',
                $syllable,
                $expectedToneMarked,
                $toneMarked
            )
        );
    }

    /**
     * @return array[]
     */
    public function toneMarkedProvider(): array
    {
        return [
            ['', ''],
            ['a', 'a'],
            ['A', 'A'],
            ['a0', 'a'],
            ['A0', 'A'],
            ['a1', 'ā'],
            ['A1', 'Ā'],
            ['a2', 'á'],
            ['A2', 'Á'],
            ['a3', 'ǎ'],
            ['A3', 'Ǎ'],
            ['a4', 'à'],
            ['A4', 'À'],
            ['a5', 'a'],
            ['A5', 'A'],
            ['ai', 'ai'],
            ['AI', 'Ai'],
            ['ai0', 'ai'],
            ['AI0', 'Ai'],
            ['ai1', 'āi'],
            ['AI1', 'Āi'],
            ['ai2', 'ái'],
            ['AI2', 'Ái'],
            ['ai3', 'ǎi'],
            ['AI3', 'Ǎi'],
            ['ai4', 'ài'],
            ['AI4', 'Ài'],
            ['ai5', 'ai'],
            ['AI5', 'Ai'],
            ['b', ''],
            ['Bei3', 'Běi'],
            ['BEI3', 'Běi'],
            ['biang1', 'biāng'],
            ['guǎn', 'guǎn'],
            ['lv4', 'lǜ'],
            ['lve4', 'lüè'],
            ['Lüe4', 'Lüè'],
            ['Lüè', 'Lüè'],
            ['ma0', 'ma'],
            ['me', 'me'],
            ['miu0', 'miu'],
            ['miu1', 'miū'],
            ['miu2', 'miú'],
            ['miu3', 'miǔ'],
            ['miu4', 'miù'],
            ['miu5', 'miu'],
            ['ne5', 'ne'],
            ['ni3', 'nǐ'],
            ['qing2', 'qíng'],
            ['qu4', 'qù'],
            ['rì', 'rì'],
            ['sēn', 'sēn'],
            ['sēng', 'sēng'],
            ['wó', 'wó'],
            ['xiu1', 'xiū'],
            ['à', 'à'],
            ['À', 'À'],
            ['ài', 'ài'],
            ['Ài', 'Ài'],
            ['á', 'á'],
            ['Á', 'Á'],
            ['ái', 'ái'],
            ['Ái', 'Ái'],
            ['ā', 'ā'],
            ['Ā', 'Ā'],
            ['āi', 'āi'],
            ['Āi', 'Āi'],
            ['ǎ', 'ǎ'],
            ['Ǎ', 'Ǎ'],
            ['ǎi', 'ǎi'],
            ['Ǎi', 'Ǎi'],
            ['dianr3', 'diǎnr'],
            ['kuair4', 'kuàir'],
            ['wanr2', 'wánr'],
        ];
    }
}
