<?php

namespace Pinyin\Tests\Unit\PinyinRegex;

use PHPUnit\Framework\TestCase;
use Pinyin\PinyinRegex;

class PinyinRegexExtractFirstFinalTest extends TestCase
{
    /**
     * @dataProvider extractFirstFinalProvider
     *
     * @param  string  $input
     * @param  string  $expectedFirstFinal
     */
    public function testExtractFirstFinal(
        string $input,
        string $expectedFirstFinal
    ) {
        // Given an input string;

        // When we extract the first pinyin final;
        $final = PinyinRegex::extractFirstFinal($input);

        // Then we should get the best final.
        self::assertSame(
            $expectedFirstFinal,
            $final,
            sprintf(
                'First final from "%s" should be "%s", got "%s"',
                $input,
                $expectedFirstFinal,
                $final
            )
        );
    }

    /**
     * @return array[]
     */
    public function extractFirstFinalProvider(): array
    {
        return [
            ['chou2', 'ou'],
            ['ri5', 'i'],
            ['pōu', 'ou'],
            ['zěn', 'en'],
            ['kan5', 'an'],
            ['kui1', 'ui'],
            ['zhuàn', 'uan'],
            ['ze2', 'e'],
            ['kōng', 'ong'],
            ['lüè', 'üe'],
            ['iong', 'iong'],
            ['iang', 'iang'],
            ['ueng', 'ueng'],
            ['uang', 'uang'],
            ['ian', 'ian'],
            ['iao', 'iao'],
            ['uai', 'uai'],
            ['uan', 'uan'],
            ['ong', 'ong'],
            ['eng', 'eng'],
            ['ing', 'ing'],
            ['üan', 'üan'],
            ['van', 'van'],
            ['ang', 'ang'],
            ['un', 'un'],
            ['üe', 'üe'],
            ['ui', 'ui'],
            ['ün', 'ün'],
            ['ve', 've'],
            ['uo', 'uo'],
            ['ua', 'ua'],
            ['vn', 'vn'],
            ['ou', 'ou'],
            ['ai', 'ai'],
            ['in', 'in'],
            ['iu', 'iu'],
            ['ie', 'ie'],
            ['ia', 'ia'],
            ['er', 'er'],
            ['en', 'en'],
            ['an', 'an'],
            ['ao', 'ao'],
            ['ei', 'ei'],
            ['o', 'o'],
            ['e', 'e'],
            ['a', 'a'],
            ['v', 'v'],
            ['ü', 'ü'],
            ['u', 'u'],
            ['i', 'i'],
        ];
    }
}
