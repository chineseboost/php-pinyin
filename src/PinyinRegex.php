<?php

namespace Pinyin;

use Normalizer;

class PinyinRegex
{
    /**
     * This is a permissive regex pattern that tries to match a pinyin syllable.
     * It is not a validation pattern.
     */
    // phpcs:disable
    const SYLLABLE_PATTERN = <<<REGEXP
/(ch|sh|b|c|zh|d|f|g|h|j|k|l|m|n|p|q|r|s|t|x|z|y|w)?(iong|īong|íong|ǐong|ìong|iang|iāng|iáng|iǎng|iàng|ueng|uēng|uéng|uěng|uèng|uang|uāng|uáng|uǎng|uàng|ian|iān|ián|iǎn|iàn|iao|iāo|iáo|iǎo|iào|uai|uāi|uái|uǎi|uài|uan|uān|uán|uǎn|uàn|ong|ōng|óng|ǒng|òng|eng|ēng|éng|ěng|èng|ing|īng|íng|ǐng|ìng|üan|üān|üán|üǎn|üàn|van|vān|ván|vǎn|vàn|ang|āng|áng|ǎng|àng|un|ūn|ún|ǔn|ùn|üe|üē|üé|üě|üè|ui|uī|uí|uǐ|uì|ün|ǖn|ǘn|ǚn|ǜn|ve|vē|vé|vě|vè|uo|uō|uó|uǒ|uò|ua|uā|uá|uǎ|uà|vn|v̄n|v́n|v̌n|v̀n|ou|ōu|óu|ǒu|òu|ai|āi|ái|ǎi|ài|in|īn|ín|ǐn|ìn|iu|iū|iú|iǔ|iù|ie|iē|ié|iě|iè|ia|iā|iá|iǎ|ià|er|ēr|ér|ěr|èr|en|ēn|én|ěn|èn|an|ān|án|ǎn|àn|ao|āo|áo|ǎo|ào|ei|ēi|éi|ěi|èi|o|ō|ó|ǒ|ò|e|ē|é|ě|è|a|ā|á|ǎ|à|v|v̄|v́|v̌|v̀|ü|ǖ|ǘ|ǚ|ǜ|u|ū|ú|ǔ|ù|i|ī|í|ǐ|ì)(r)?([0-5])?/ui
REGEXP
    ;
    // phpcs:enable

    public static function extractFirstSyllable(string $haystack): string
    {
        mb_internal_encoding('UTF-8');
        $haystack = Normalizer::normalize(trim($haystack));
        $haystack = preg_replace('/[^\p{L}0-5]/u', '', $haystack);
        $haystack = mb_substr($haystack, 0, 6);
        preg_match(static::SYLLABLE_PATTERN, $haystack, $matches);
        return $matches[0] ?? '';
    }

    /**
     * Dev utility to generate the SYLLABLE_PATTERN above.
     *
     * @return string
     */
    public static function generateSyllablePattern(): string
    {
        return Normalizer::normalize(
            sprintf(
                '/(%s)?(%s)(r)?([0-5])?/ui',
                implode(
                    '|',
                    array_merge(PinyinInitial::INITIALS, PinyinInitial::ORTHOGRAPHICS)
                ),
                implode(
                    '|',
                    array_merge(
                        ...array_map(
                            function (string $final): array {
                                return array_map(
                                    function (int $tone) use ($final): string {
                                        return PinyinTone::applyToneMark($final, $tone);
                                    },
                                    PinyinTone::TONE_NUMBERS
                                );
                            },
                            PinyinFinal::FINALS
                        )
                    )
                )
            )
        );
    }

    public function __toString()
    {
        return static::SYLLABLE_PATTERN;
    }
}
