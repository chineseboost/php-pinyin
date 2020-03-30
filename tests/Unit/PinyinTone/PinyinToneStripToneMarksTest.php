<?php

namespace Pinyin\Tests\Unit\PinyinTone;

use PHPUnit\Framework\TestCase;
use Pinyin\PinyinTone;

class PinyinToneStripToneMarksTest extends TestCase
{
    /**
     * @dataProvider stripToneMarksProvider
     *
     * @param string $subject
     * @param string $expectedStripped
     */
    public function testStripToneMarks(string $subject, string $expectedStripped): void
    {
        // Given an input string;

        // When we strip it of pinyin tone marks;
        $stripped = PinyinTone::stripToneMarks($subject);

        // Then pinyin tone marks should be correctly stripped.
        self::assertSame($expectedStripped, $stripped);
    }

    /**
     * @return array[]
     */
    public function stripToneMarksProvider(): array
    {
        return [
            ['', ''],
            ['a', 'a'],
            [' a  ', 'a'],
            [' a1  ', 'a1'],
            [' ā  ', 'a'],
            ['yi1', 'yi1'],
            ['yī', 'yi'],
            ['èr', 'er'],
            ['sān', 'san'],
            ['sì', 'si'],
            ['wǔ', 'wu'],
            ['liù', 'liu'],
            ['qī', 'qi'],
            ['bā', 'ba'],
            ['jiǔ', 'jiu'],
            ['shí', 'shi'],
            ['lǜsè', 'lüse'],
            ['Zhōnghuá Rénmín Gònghéguó', 'Zhonghua Renmin Gongheguo'],
        ];
    }
}
