<?php

namespace Pinyin\Tests\Unit\PinyinTone;

use PHPUnit\Framework\TestCase;
use Pinyin\PinyinTone;

class PinyinToneToneChecksTest extends TestCase
{
    /**
     * @dataProvider isFirstProvider
     *
     * @param string $syllable
     * @param bool   $expectedIsFirst
     */
    public function testIsFirst(string $syllable, bool $expectedIsFirst)
    {
        // Given a pinyin tone for a syllable;
        $tone = PinyinTone::fromPinyinSyllableString($syllable);

        // When we check if it is first tone;
        $isFirst = $tone->isFirst();

        // Then we should get the correct result.
        self::assertSame($expectedIsFirst, $isFirst);
    }

    /**
     * @return array
     */
    public function isFirstProvider(): array
    {
        return [
            ['tou1', true],
            ['xīng', true],
            ['rou', false],
            ['wang2', false],
            ['pǔ', false],
        ];
    }

    /**
     * @dataProvider isSecondProvider
     *
     * @param string $syllable
     * @param bool   $expectedIsSecond
     */
    public function testIsSecond(string $syllable, bool $expectedIsSecond)
    {
        // Given a pinyin tone for a syllable;
        $tone = PinyinTone::fromPinyinSyllableString($syllable);

        // When we check if it is second tone;
        $isSecond = $tone->isSecond();

        // Then we should get the correct result.
        self::assertSame($expectedIsSecond, $isSecond);
    }

    /**
     * @return array
     */
    public function isSecondProvider(): array
    {
        return [
            ['ye2', true],
            ['zhóng', true],
            ['sen', false],
            ['wai1', false],
            ['pèi', false],
        ];
    }

    /**
     * @dataProvider isThirdProvider
     *
     * @param string $syllable
     * @param bool   $expectedIsThird
     */
    public function testIsThird(string $syllable, bool $expectedIsThird)
    {
        // Given a pinyin tone for a syllable;
        $tone = PinyinTone::fromPinyinSyllableString($syllable);

        // When we check if it is third tone;
        $isThird = $tone->isThird();

        // Then we should get the correct result.
        self::assertSame($expectedIsThird, $isThird);
    }

    /**
     * @return array
     */
    public function isThirdProvider(): array
    {
        return [
            ['pan3', true],
            ['wěng', true],
            ['chan', false],
            ['yue4', false],
            ['jín', false],
        ];
    }

    /**
     * @dataProvider isFourthProvider
     *
     * @param string $syllable
     * @param bool   $expectedIsFourth
     */
    public function testIsFourth(string $syllable, bool $expectedIsFourth)
    {
        // Given a pinyin tone for a syllable;
        $tone = PinyinTone::fromPinyinSyllableString($syllable);

        // When we check if it is fourth tone;
        $isFourth = $tone->isFourth();

        // Then we should get the correct result.
        self::assertSame($expectedIsFourth, $isFourth);
    }

    /**
     * @return array
     */
    public function isFourthProvider(): array
    {
        return [
            ['pa4', true],
            ['tìng', true],
            ['duo', false],
            ['céng', false],
            ['miu3', false],
        ];
    }

    /**
     * @dataProvider isNeutralProvider
     *
     * @param string $syllable
     * @param bool   $expectedIsNeutral
     */
    public function testIsNeutral(string $syllable, bool $expectedIsNeutral)
    {
        // Given a pinyin tone for a syllable;
        $tone = PinyinTone::fromPinyinSyllableString($syllable);

        // When we check if it is neutral tone;
        $isNeutral = $tone->isNeutral();

        // Then we should get the correct result.
        self::assertSame($expectedIsNeutral, $isNeutral);
    }

    /**
     * @return array
     */
    public function isNeutralProvider(): array
    {
        return [
            ['ne', true],
            ['me5', true],
            ['le0', true],
            ['·ma', true],
            ['zhōu', false],
            ['bing4', false],
        ];
    }
}
