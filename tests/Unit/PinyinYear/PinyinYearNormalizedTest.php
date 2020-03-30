<?php

namespace Pinyin\Tests\Unit\PinyinYear;

use PHPUnit\Framework\TestCase;
use Pinyin\PinyinYear;

class PinyinYearNormalizedTest extends TestCase
{
    /**
     * @dataProvider yearProvider
     *
     * @param string $year
     * @param string $expectedNormalized
     */
    public function testNormalized(string $year, string $expectedNormalized): void
    {
        // Given a pinyin year;
        $pinyinYear = new PinyinYear($year);

        // When we normalize it;
        $normalized = (string) $pinyinYear->normalized();

        // Then we should get the correct normalized year.
        self::assertSame(
            $expectedNormalized,
            $normalized,
            sprintf(
                '%s should normalize to %s, got %s',
                $year,
                $expectedNormalized,
                $normalized
            )
        );
    }

    /**
     * @return array[]
     */
    public function yearProvider(): array
    {
        return [
            ['1998 nian', 'yi1 jiu3 jiu3 ba1 nian2'],
            ['1998 nián', 'yī jiǔ jiǔ bā nián'],
            ['2020nian2', 'er4 ling2 er4 ling2 nian2'],
            ['2020nián', 'èr líng èr líng nián'],
            ['220 nian', 'er4 er4 ling2 nian2'],
            ['220 nián', 'èr èr líng nián'],
            ['80 nian', 'ba1 ling2 nian2'],
            ['80 nián', 'bā líng nián'],
            ['80 hou', 'ba1 ling2 hou4'],
            ['80hou4', 'ba1 ling2 hou4'],
            ['89hòu', 'bā jiǔ hòu'],
        ];
    }
}
