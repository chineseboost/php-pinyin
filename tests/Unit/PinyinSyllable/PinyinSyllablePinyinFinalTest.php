<?php

namespace Pinyin\Tests\Unit\PinyinSyllable;

use PHPUnit\Framework\TestCase;
use Pinyin\PinyinFinal;
use Pinyin\PinyinSyllable;

class PinyinSyllablePinyinFinalTest extends TestCase
{
    /**
     * @dataProvider pinyinFinalProvider
     *
     * @param string $syllable
     * @param string $expectedFinal
     */
    public function testPinyinFinal(string $syllable, string $expectedFinal)
    {
        // Given a pinyin syllable;
        $pinyinSyllable = new PinyinSyllable($syllable);

        // When we get the final;
        $final = $pinyinSyllable->pinyinFinal();

        // Then we should get the correct final.
        self::assertInstanceOf(PinyinFinal::class, $final);
        self::assertSame(
            $expectedFinal,
            (string) $final,
            sprintf(
                'Pinyin final for "%s" should be "%s", got "%s"',
                $syllable,
                $expectedFinal,
                $final
            )
        );
    }

    /**
     * @return array[]
     */
    public function pinyinFinalProvider(): array
    {
        return [
            ['a', 'a'],
            ['beng3', 'eng'],
            ['duǎng', 'uang'],
            ['dàn', 'an'],
            ['e', 'e'],
            ['han', 'an'],
            ['i', 'yi'],
            ['o', 'o'],
            ['rēng', 'eng'],
            ['v', 'yu'],
            ['wu', 'wu'],
            ['xie', 'ie'],
            ['yu', 'yu'],
            ['yuàn', 'yuan'],
            ['zuì', 'ui'],
            ['zuī', 'ui'],
            ['ü', 'yu'],
        ];
    }
}
