<?php

namespace Pinyin\Tests\Unit\PinyinSyllable;

use PHPUnit\Framework\TestCase;
use Pinyin\PinyinSyllable;

class PinyinSyllableToneNumberedTest extends TestCase
{
    /**
     * @dataProvider toneNumberedProvider
     *
     * @param string $syllable
     * @param string $expectedToneNumbered
     */
    public function testToneNumbered(string $syllable, string $expectedToneNumbered)
    {
        // Given we have a pinyin syllable;
        $pinyinSyllable = new PinyinSyllable($syllable);

        // When we get it tone-numbered;
        $toneNumbered = $pinyinSyllable->toneNumbered();

        // Then it should be correctly tone-numbered;
        self::assertSame(
            $expectedToneNumbered,
            (string) $toneNumbered,
            sprintf(
                'Syllable "%s" should be "%s" when tone-numbered, got "%s"',
                $syllable,
                $expectedToneNumbered,
                $toneNumbered
            )
        );
    }

    /**
     * @return array[]
     */
    public function toneNumberedProvider(): array
    {
        return [
            ['', ''],
            ['a', 'a'],
            ['A', 'A'],
            ['a0', 'a'],
            ['A0', 'A'],
            ['a1', 'a1'],
            ['A1', 'A1'],
            ['a2', 'a2'],
            ['A2', 'A2'],
            ['a3', 'a3'],
            ['A3', 'A3'],
            ['a4', 'a4'],
            ['A4', 'A4'],
            ['a5', 'a'],
            ['A5', 'A'],
            ['ai', 'ai'],
            ['AI', 'Ai'],
            ['ai0', 'ai'],
            ['AI0', 'Ai'],
            ['ai1', 'ai1'],
            ['AI1', 'Ai1'],
            ['ai2', 'ai2'],
            ['AI2', 'Ai2'],
            ['ai3', 'ai3'],
            ['AI3', 'Ai3'],
            ['ai4', 'ai4'],
            ['AI4', 'Ai4'],
            ['ai5', 'ai'],
            ['AI5', 'Ai'],
            ['b', 'b'],
            ['Bei3', 'Bei3'],
            ['BEI3', 'Bei3'],
            ['biang1', 'biang1'],
            ['Běi', 'Bei3'],
            ['guǎn', 'guan3'],
            ['lv4', 'lü4'],
            ['lve4', 'lüe4'],
            ['Lüe4', 'Lüe4'],
            ['Lüè', 'Lüe4'],
            ['ma0', 'ma'],
            ['me', 'me'],
            ['ne5', 'ne'],
            ['ni3', 'ni3'],
            ['qing2', 'qing2'],
            ['qu4', 'qu4'],
            ['rì', 'ri4'],
            ['sēn', 'sen1'],
            ['wó', 'wo2'],
            ['xiu1', 'xiu1'],
            ['à', 'a4'],
            ['À', 'A4'],
            ['ài', 'ai4'],
            ['Ài', 'Ai4'],
            ['á', 'a2'],
            ['Á', 'A2'],
            ['ái', 'ai2'],
            ['Ái', 'Ai2'],
            ['ā', 'a1'],
            ['Ā', 'A1'],
            ['āi', 'ai1'],
            ['Āi', 'Ai1'],
            ['ǎ', 'a3'],
            ['Ǎ', 'A3'],
            ['ǎi', 'ai3'],
            ['Ǎi', 'Ai3'],
        ];
    }
}
