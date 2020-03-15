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
            ['1998 nian', 'yī jiǔ jiǔ bā nián'],
            ['2020nian2', 'èr líng èr líng nián'],
            ['220 nian', 'èr èr líng nián'],
            ['80 nian', 'bā líng nián'],
        ];
    }
}
