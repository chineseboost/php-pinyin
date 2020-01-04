<?php

namespace Pinyin\Tests\Unit\PinyinSyllable;

use PHPUnit\Framework\TestCase;
use Pinyin\PinyinSyllable;

class PinyinSyllablePlainTest extends TestCase
{
    /**
     * @dataProvider plainProvider
     *
     * @param string $syllable
     * @param string $expectedPlain
     */
    public function testPlain(string $syllable, string $expectedPlain)
    {
        // Given we have a pinyin syllable;
        $pinyinSyllable = new PinyinSyllable($syllable);

        // When we get it plain and unmarked;
        $plain = $pinyinSyllable->plain();

        // Then it should be correctly normalized.
        self::assertSame(
            $expectedPlain,
            (string) $plain,
            sprintf(
                'Syllable "%s" should be "%s" when plain, got "%s"',
                $syllable,
                $expectedPlain,
                $plain
            )
        );
    }

    /**
     * @return array[]
     */
    public function plainProvider(): array
    {
        return [
            ['', ''],
            ['a', 'a'],
            [' a  ', 'a'],
            [' a1  ', 'a'],
            [' ā  ', 'a'],
            [" \nnian3  ", 'nian'],
            [" \tkao6  ", 'kao'],
            [' zui0 ', 'zui'],
            [' meng5 ', 'meng'],
            ['-_++==shen1^%', 'shen'],
        ];
    }
}
