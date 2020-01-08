<?php

namespace Pinyin\Tests\Unit\PinyinTone;

use PHPUnit\Framework\TestCase;
use Pinyin\PinyinTone;

class PinyinToneToneNumberTest extends TestCase
{
    /**
     * @dataProvider syllableToneNumberProvider
     *
     * @param string $syllable
     * @param int    $expectedToneNumber
     */
    public function testToneNumber(string $syllable, int $expectedToneNumber)
    {
        // Given we have a pinyin syllable;

        // When we make a pinyin tone from it;
        $pinyinTone = PinyinTone::fromPinyinSyllableString($syllable);

        // Then it should be the correct tone number.
        self::assertSame(
            $expectedToneNumber,
            $pinyinTone->number(),
            sprintf(
                'Tone number for "%s" should be %d, but got %d',
                $syllable,
                $expectedToneNumber,
                $pinyinTone->number()
            )
        );
        self::assertSame(
            (string) $expectedToneNumber,
            (string) $pinyinTone,
            sprintf(
                'Tone number for "%s" should be %d, but got %d',
                $syllable,
                $expectedToneNumber,
                $pinyinTone->number()
            )
        );
    }

    /**
     * @return string[]
     */
    public function syllableToneNumberProvider(): array
    {
        return [
            ['chuang', 0],
            ['ting', 0],
            ['ne', 0],
            ['ying', 0],
            ['dian', 0],
            ['yao0', 0],
            ['ai0', 0],
            ['xiao0', 0],
            ['shuan0', 0],
            ['zhong0', 0],
            ['mi1', 1],
            ['jue1', 1],
            ['dang1', 1],
            ['jia1', 1],
            ['nang1', 1],
            ['fu2', 2],
            ['ji2', 2],
            ['le2', 2],
            ['chi2', 2],
            ['jun2', 2],
            ['wang3', 3],
            ['mie3', 3],
            ['lin3', 3],
            ['ba3', 3],
            ['long3', 3],
            ['tun4', 4],
            ['shui4', 4],
            ['lie4', 4],
            ['chuai4', 4],
            ['zun4', 4],
            ['mi5', 0],
            ['ang5', 0],
            ['cai5', 0],
            ['bi5', 0],
            ['zu5', 0],
            ['nā', 1],
            ['nēi', 1],
            ['bīn', 1],
            ['xiōng', 1],
            ['yū', 1],
            ['lǖ', 1],
            ['niáo', 2],
            ['hén', 2],
            ['mí', 2],
            ['chóu', 2],
            ['zhú', 2],
            ['lǘ', 2],
            ['kuǎn', 3],
            ['kě', 3],
            ['xiě', 3],
            ['guǐ', 3],
            ['mǒu', 3],
            ['fǔ', 3],
            ['mài', 4],
            ['è', 4],
            ['bìng', 4],
            ['lòng', 4],
            ['lǜ', 4],
            ['nüè', 4],
            ['cai5', 0],
            ['li5', 0],
            ['ca5', 0],
            ['lü5', 0],
            ['zen5', 0],
        ];
    }
}
