<?php

namespace Pinyin\Tests\Unit\PinyinWord;

use PHPUnit\Framework\TestCase;
use Pinyin\PinyinWord;

class PinyinWordSyllablesTest extends TestCase
{
    /**
     * @dataProvider syllablesProvider
     *
     * @param string   $word
     * @param string[] $expectedSyllables
     */
    public function testSyllables(string $word, array $expectedSyllables): void
    {
        // Given a pinyin word;
        $pinyinWord = new PinyinWord($word);

        // When we get the pinyin syllables;
        $syllables = $pinyinWord->syllables();

        // Then we should get the correct syllables.
        self::assertCount(
            count($expectedSyllables),
            $syllables,
            sprintf(
                "'%s' should have %d syllables ('%s'), got %d ('%s')",
                $word,
                count($expectedSyllables),
                implode("', '", $expectedSyllables),
                count($syllables),
                implode("', '", $syllables)
            )
        );
        foreach ($expectedSyllables as $i => $expectedSyllable) {
            self::assertSame(
                (string) $expectedSyllable,
                (string) ($syllables[$i]),
                sprintf(
                    "#%d syllable of '%s' should be '%s', got '%s'",
                    $i,
                    $word,
                    $expectedSyllable,
                    $syllables[$i]
                )
            );
        }
    }

    public function syllablesProvider(): array
    {
        return [
            ['Qing1dao3', ['Qing1', 'dao3']],
            ['Bei3 jing1', ['Bei3', 'jing1']],
            ['erhua', ['er', 'hua']],
            ['daor', ['daor']],
            ['wēnxīn', ['wēn', 'xīn']],
            ['Zhōngguó Rénmín Gònghéguó', ['Zhōng', 'guó', 'Rén', 'mín', 'Gòng', 'hé', 'guó']],
            ['2020nián', ['èr', 'líng', 'èr', 'líng', 'nián']],
            ['2020nian2', ['er4', 'ling2', 'er4', 'ling2', 'nian2']],
            ['Xué', ['Xué']],
        ];
    }
}
