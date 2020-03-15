<?php

namespace Pinyin\Tests\Unit\PinyinYear;

use PHPUnit\Framework\TestCase;
use Pinyin\PinyinYear;

class PinyinYearReplaceYearsTest extends TestCase
{
    /**
     * @dataProvider replaceYearsProvider
     *
     * @param string $input
     * @param string $expectedReplaced
     */
    public function testReplaceYears(string $input, string $expectedReplaced): void
    {
        // Given a pinyin string containing apparent years;

        // When we replace the year digits with pinyin;
        $replaced = PinyinYear::replaceYears($input);

        // Then they should be correctly replaced.
        self::assertSame(
            $expectedReplaced,
            $replaced,
            sprintf(
                'Digit years in %s should be replaced with %s, got %s',
                $input,
                $expectedReplaced,
                $replaced
            )
        );
    }

    /**
     * @return array[]
     */
    public function replaceYearsProvider(): array
    {
        return [
            ['Tā shì 1980 nián chūshēng de.', 'Tā shì yī jiǔ bā líng nián chūshēng de.'],
        ];
    }
}
