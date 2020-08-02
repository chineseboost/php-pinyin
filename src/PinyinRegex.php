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
    const SYLLABLE_PATTERN = <<<'REGEXP'
/(ch|sh|zh|b|c|d|f|g|h|j|k|l|m|n|p|q|r|s|t|x|z|y|w)?(iong|īong|íong|ǐong|ìong|iang|iāng|iáng|iǎng|iàng|ueng|uēng|uéng|uěng|uèng|uang|uāng|uáng|uǎng|uàng|ian|iān|ián|iǎn|iàn|iao|iāo|iáo|iǎo|iào|uai|uāi|uái|uǎi|uài|uan|uān|uán|uǎn|uàn|ong|ōng|óng|ǒng|òng|eng|ēng|éng|ěng|èng|ing|īng|íng|ǐng|ìng|üan|üān|üán|üǎn|üàn|van|vān|ván|vǎn|vàn|ang|āng|áng|ǎng|àng|un|ūn|ún|ǔn|ùn|ue|uē|ué|uě|uè|üe|üē|üé|üě|üè|ui|uī|uí|uǐ|uì|ün|ǖn|ǘn|ǚn|ǜn|ve|vē|vé|vě|vè|uo|uō|uó|uǒ|uò|ua|uā|uá|uǎ|uà|vn|v̄n|v́n|v̌n|v̀n|ou|ōu|óu|ǒu|òu|ai|āi|ái|ǎi|ài|in|īn|ín|ǐn|ìn|iu|iū|iú|iǔ|iù|ie|iē|ié|iě|iè|ia|iā|iá|iǎ|ià|er|ēr|ér|ěr|èr|en|ēn|én|ěn|èn|an|ān|án|ǎn|àn|ao|āo|áo|ǎo|ào|ei|ēi|éi|ěi|èi|o|ō|ó|ǒ|ò|e|ē|é|ě|è|a|ā|á|ǎ|à|v|v̄|v́|v̌|v̀|ü|ǖ|ǘ|ǚ|ǜ|u|ū|ú|ǔ|ù|i|ī|í|ǐ|ì)(r([0-5]|\b)|[0-5])?/ui
REGEXP;
    // phpcs:enable

    const INITIAL_PATTERN = <<<'REGEXP'
/(ch|sh|zh|b|c|d|f|g|h|j|k|l|m|n|p|q|r|s|t|x|z)/ui
REGEXP;

    // phpcs:disable
    const FINAL_PATTERN = <<<'REGEXP'
/(iong|īong|íong|ǐong|ìong|iang|iāng|iáng|iǎng|iàng|ueng|uēng|uéng|uěng|uèng|uang|uāng|uáng|uǎng|uàng|ian|iān|ián|iǎn|iàn|iao|iāo|iáo|iǎo|iào|uai|uāi|uái|uǎi|uài|uan|uān|uán|uǎn|uàn|ong|ōng|óng|ǒng|òng|eng|ēng|éng|ěng|èng|ing|īng|íng|ǐng|ìng|üan|üān|üán|üǎn|üàn|van|vān|ván|vǎn|vàn|ang|āng|áng|ǎng|àng|un|ūn|ún|ǔn|ùn|üe|üē|üé|üě|üè|ui|uī|uí|uǐ|uì|ün|ǖn|ǘn|ǚn|ǜn|ve|vē|vé|vě|vè|uo|uō|uó|uǒ|uò|ua|uā|uá|uǎ|uà|vn|v̄n|v́n|v̌n|v̀n|ou|ōu|óu|ǒu|òu|ai|āi|ái|ǎi|ài|in|īn|ín|ǐn|ìn|iu|iū|iú|iǔ|iù|ie|iē|ié|iě|iè|ia|iā|iá|iǎ|ià|er|ēr|ér|ěr|èr|en|ēn|én|ěn|èn|an|ān|án|ǎn|àn|ao|āo|áo|ǎo|ào|ei|ēi|éi|ěi|èi|o|ō|ó|ǒ|ò|e|ē|é|ě|è|a|ā|á|ǎ|à|v|v̄|v́|v̌|v̀|ü|ǖ|ǘ|ǚ|ǜ|u|ū|ú|ǔ|ù|i|ī|í|ǐ|ì)(r)?/ui
REGEXP;
    // phpcs:enable

    const TONE_MARKED_PATTERN = <<<'REGEXP'
/[àáèéìíòóùúāēěīōūǎǐǒǔǖǘǚǜ]/u
REGEXP;

    const NORMALIZATIONS = [
        '/v/u'               => 'ü',
        '/V/u'               => 'Ü',
        '/^i/u'              => 'yi',
        '/^I/u'              => 'Yi',
        '/^y?ie$/u'          => 'ye',
        '/^Y?[Ii][eE]$/u'    => 'Ye',
        '/^y?iu$/u'          => 'you',
        '/^Y?[Ii][uU]$/u'    => 'You',
        '/^un$/u'            => 'wen',
        '/^Un$/u'            => 'Wen',
        '/^ü/u'              => 'yu',
        '/^Ü/u'              => 'Yu',
        '/^u$/u'             => 'wu',
        '/^U$/u'             => 'Wu',
        '/^ui$/u'            => 'wei',
        '/^U[iI]$/u'         => 'Wei',
        '/^u/u'              => 'w',
        '/^U/u'              => 'W',
        '/(y|Y)i([^n0-9])/u' => '$1$2',
        '/([jqx])ü/u'        => '$1u',
    ];

    public static function extractFirstSyllable(string $haystack): string
    {
        $haystack = static::normalize($haystack);
        preg_match(static::SYLLABLE_PATTERN, $haystack, $matches);

        return $matches[0] ?? '';
    }

    public static function extractFirstInitial(string $haystack): string
    {
        $haystack = static::normalize($haystack);
        $haystack = mb_substr($haystack, 0, 2);
        preg_match(static::INITIAL_PATTERN, $haystack, $matches);

        return mb_strtolower($matches[0] ?? '');
    }

    public static function extractFirstFinal(string $haystack): string
    {
        $haystack = static::normalize($haystack);
        $haystack = mb_substr($haystack, 0, 6);
        preg_match(static::FINAL_PATTERN, $haystack, $matches);
        $final = $matches[0] ?? '';
        if (preg_match('/^[wy]/ui', $haystack)) {
            $final = mb_substr($haystack, 0, 1).$final;
        }

        return mb_strtolower(PinyinTone::stripToneMarks($final));
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
                '/(%s)?(%s)(r([0-5]|\b)|[0-5])?/ui',
                implode('|', array_merge(PinyinInitial::INITIALS, PinyinInitial::ORTHOGRAPHICS)),
                implode(
                    '|',
                    array_merge(
                        ...array_map(
                            static function (string $final): array {
                                return array_map(
                                    static function (int $tone) use ($final): string {
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

    public static function normalize(string $input): string
    {
        mb_internal_encoding('UTF-8');
        $input = Normalizer::normalize(trim($input));
        $input = preg_replace('/[^\p{L}0-5 ]/u', '', $input);

        return $input;
    }

    public function __toString()
    {
        return static::SYLLABLE_PATTERN;
    }
}
