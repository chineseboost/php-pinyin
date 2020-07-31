<?php

namespace Pinyin;

use Pinyin\String\HtmlAble;
use Pinyin\String\Normalizing;
use Pinyin\String\Stringable;

class PinyinSentence implements Stringable, HtmlAble, Normalizing
{
    /** @var string */
    private $sentence;

    /** @var int */
    private $wordLimit;

    /** @var bool */
    private $replaceYears;

    /**
     * @param string $sentence
     * @param int    $wordLimit
     * @param bool   $replaceYears
     */
    public function __construct(
        string $sentence,
        int $wordLimit = 1000,
        bool $replaceYears = true
    ) {
        $this->sentence = $sentence;
        $this->wordLimit = $wordLimit;
        $this->replaceYears = $replaceYears;
    }

    public function toneMarked(): self
    {
        return new static(
            implode(
                '',
                array_map(
                    static function (Normalizing $element): Normalizing {
                        if ($element instanceof PinyinWord) {
                            return $element->toneMarked();
                        }

                        return $element;
                    },
                    $this->elements()
                )
            )
        );
    }

    public function normalized(): Normalizing
    {
        $normalized = $this->sentence;
        if ($this->replaceYears) {
            $normalized = PinyinYear::replaceYears($normalized);
        }
        $normalized = preg_replace(
            '/(\S)([A-Z])/u',
            '$1 $2',
            $normalized
        );
        $normalized = preg_replace(
            '/\s+/u',
            ' ',
            $normalized
        );

        return new static($normalized);
    }

    /**
     * @return PinyinWord[]
     */
    public function words(): array
    {
        return array_values(
            array_filter(
                $this->elements(),
                static function (Normalizing $element): bool {
                    return $element instanceof PinyinWord;
                }
            )
        );
    }

    /**
     * @return PinyinSyllable[]
     */
    public function syllables(): array
    {
        $syllables = [];
        foreach ($this->words() as $word) {
            foreach ($word->syllables() as $syllable) {
                $syllables[] = $syllable;
            }
        }

        return $syllables;
    }

    /**
     * @return Normalizing[]
     */
    public function elements(): array
    {
        $elements = [];

        $naturalWords = preg_split(
            '/(\s+)/u',
            (string) $this->normalized(),
            -1,
            PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE
        );
        foreach ($naturalWords as $naturalWord) {
            if (preg_match('/^\s+$/u', $naturalWord) === 1) {
                $elements[] = new NonPinyinString(' ');
                continue;
            }
            $remaining = $naturalWord;
            $joinedWord = '';
            for ($i = 0; $remaining !== '' && $i < $this->wordLimit; $i++) {
                $nextSyllable = PinyinRegex::extractFirstSyllable($remaining);

                if ($nextSyllable === $naturalWord) {
                    // Natural word is a valid syllable.
                    // Add and go to the next natural word.
                    $elements[] = new PinyinWord(trim($nextSyllable));
                    break;
                }

                if ($nextSyllable === $remaining) {
                    // We've finished this joined word.
                    // Add and go to the next natural word.
                    $joinedWord .= $nextSyllable;
                    $elements[] = new PinyinWord(trim($joinedWord));
                    break;
                }

                if (!$nextSyllable) {
                    // No more valid syllables.
                    if ($joinedWord) {
                        // Add the joined word so far.
                        $elements[] = new PinyinWord($joinedWord);
                    }
                    if ($remaining) {
                        // Add any remaining non-pinyin.
                        $elements[] = new NonPinyinString($remaining);
                    }
                    // Go to the next natural word.
                    break;
                }

                $nextSyllablePos = mb_strpos($remaining, $nextSyllable);
                if ($nextSyllablePos !== 0) {
                    // There is some non-pinyin before we get to a syllable.
                    // Extract joined word so far plus non-pinyin, and continue
                    // with this natural word.
                    if ($joinedWord) {
                        $elements[] = new PinyinWord($joinedWord);
                        $joinedWord = '';
                    }
                    $nonSyllable = mb_substr($remaining, 0, $nextSyllablePos);
                    $elements[] = new NonPinyinString($nonSyllable);
                    $remaining = mb_substr($remaining, mb_strlen($nonSyllable));
                    continue;
                }

                // Next syllable is at beginning of remaining joined word.
                $firstOfNext = mb_substr($nextSyllable, 0, 1);
                if ($joinedWord && mb_strtoupper($firstOfNext) === $firstOfNext) {
                    // Uppercase new word; cut off the joined word here.
                    $elements[] = new PinyinWord($joinedWord);
                    $joinedWord = '';
                }

                $joinedWord .= $nextSyllable;
                $remaining = mb_substr($remaining, mb_strlen($nextSyllable));
            }
        }

        return $elements;
    }

    public function asHtml(): string
    {
        $elementsHtml = implode(
            '',
            array_map(
                static function (HtmlAble $element): string {
                    return $element->asHtml();
                },
                $this->elements()
            )
        );

        return trim(
            <<<HTML
<span class="pinyin sentence" lang="zh-Latn-CN-pinyin">{$elementsHtml}</span>
HTML
        );
    }

    public function __toString(): string
    {
        return $this->sentence;
    }
}
