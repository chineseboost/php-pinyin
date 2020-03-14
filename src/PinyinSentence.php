<?php

namespace Pinyin;

use Pinyin\String\Normalizing;

class PinyinSentence implements Normalizing
{
    /** @var string */
    private $sentence;

    /** @var int */
    private $wordLimit;

    /**
     * @param  string  $sentence
     * @param  int  $wordLimit
     */
    public function __construct(string $sentence, int $wordLimit = 1000)
    {
        $this->sentence = $sentence;
        $this->wordLimit = $wordLimit;
    }

    public function normalized(): Normalizing
    {
        return new static(
            preg_replace(
                '/\s+/u',
                ' ',
                PinyinRegex::normalize($this->sentence)
            )
        );
    }

    /**
     * @return Normalizing[]
     */
    public function elements(): array
    {
        $elements = [];

        $naturalWords = preg_split('/\s+/u', $this->sentence);
        foreach ($naturalWords as $naturalWord) {
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

    public function __toString(): string
    {
        return $this->sentence;
    }
}
