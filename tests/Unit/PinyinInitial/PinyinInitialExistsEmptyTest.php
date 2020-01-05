<?php

namespace Pinyin\Tests\Unit\PinyinRegex;

use PHPUnit\Framework\TestCase;
use Pinyin\PinyinSyllable;

class PinyinInitialExistsEmptyTest extends TestCase
{
    /**
     * @dataProvider existsIsEmptyProvider
     *
     * @param  string  $syllable
     * @param  bool  $expectedExists
     */
    public function testExistsIsEmpty(string $syllable, bool $expectedExists)
    {
        // Given a pinyin syllable;
        $pinyinSyllable = new PinyinSyllable($syllable);

        // When we get the initial;
        $initial = $pinyinSyllable->pinyinInitial();

        // Then we should correctly see if it exists or is empty.
        self::assertSame($expectedExists, $initial->exists());
        self::assertSame(!$expectedExists, $initial->isEmpty());
    }

    /**
     * @return array[]
     */
    public function existsIsEmptyProvider(): array
    {
        return [
            ['a', false],
            ['dan4', true],
            ['e', false],
            ['i', false],
            ['jǐn', true],
            ['lao1', true],
            ['liǔ', true],
            ['miào', true],
            ['o', false],
            ['pèn', true],
            ['u', false],
            ['v', false],
            ['wa', false],
            ['wai', false],
            ['wan', false],
            ['wang', false],
            ['wei', false],
            ['wen', false],
            ['weng', false],
            ['wo', false],
            ['wu', false],
            ['ya', false],
            ['yan', false],
            ['yang', false],
            ['yao', false],
            ['ye', false],
            ['yi', false],
            ['yin', false],
            ['ying', false],
            ['yong', false],
            ['you', false],
            ['yu', false],
            ['yuan', false],
            ['yue', false],
            ['yun', false],
            ['zhǎ', true],
            ['ü', false],
            ['', false],
        ];
    }
}
