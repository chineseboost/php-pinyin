<?php

namespace Pinyin\Tests\Unit\PinyinWord;

use PHPUnit\Framework\TestCase;
use Pinyin\PinyinWord;

class PinyinWordNormalizedTest extends TestCase
{
    /**
     * @dataProvider normalizedProvider
     *
     * @param string $word
     * @param string $expectedNormalized
     */
    public function testNormalized(string $word, string $expectedNormalized)
    {
        // Given a pinyin word;
        $pinyinWord = new PinyinWord($word);

        // When we normalize it;
        $normalized = $pinyinWord->normalized();

        // Then it should be correctly normalized.
        self::assertSame($expectedNormalized, (string) $normalized);
    }

    /**
     * @return array[]
     */
    public function normalizedProvider(): array
    {
        return [
            [' qing1dao3 ', 'qing1dao3'],
            [' xīxüèguǐ ', 'xīxuèguǐ'],
            ['Běijing1', 'Běijing1'], // TODO: would be nice if it kept tone markings consistent.
        ];
    }
}
