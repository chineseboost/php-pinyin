<?php

namespace Pinyin\Tests\Unit\PinyinRegex;

use PHPUnit\Framework\TestCase;
use Pinyin\PinyinRegex;

class PinyinRegexGenerateSyllablePatternTest extends TestCase
{
    public function testGenerateSyllablePattern(): void
    {
        // When we generate the pinyin syllable regex pattern;
        $pattern = PinyinRegex::generateSyllablePattern();

        // Then we should get the correct pattern.
        self::assertSame(PinyinRegex::SYLLABLE_PATTERN, $pattern);
        self::assertSame(PinyinRegex::SYLLABLE_PATTERN, (string) new PinyinRegex());
    }
}
