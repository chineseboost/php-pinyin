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
     * @param string $sentence
     * @param int $wordLimit
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
                '/\s+/u', ' ',
                PinyinRegex::normalize($this->sentence)
            )
        );
    }

    /**
     * @return Normalizing[]
     */
    public function elements(): array
    {
        $words = [];
        $remaining = $this->sentence;
        $currentWord = "";

        for ($i = 0; mb_strlen($remaining) > 0 && $i < $this->wordLimit; $i++) {
            $nextSyllable = PinyinRegex::extractFirstSyllable($remaining);
            if (!$nextSyllable) {
                if (mb_strlen($remaining) > 0) {
                    array_push($elements, new NonPinyinString($remaining));
                }
                break;
            }

            $nextSyllablePos = mb_strpos($remaining, $nextSyllable);
            if ($nextSyllablePos !== 0) {
                $nonSyllable = mb_substr($remaining, 0, $nextSyllablePos);
                array_push($elements, new NonPinyinString($nonSyllable));
                $remaining = mb_substr($remaining, mb_strlen($nonSyllable));
                continue;
            }

            $nextSyllableFirstLetter = mb_substr($nextSyllable, 0, 1);
            if (mb_strlen($currentWord) === 0
                || $nextSyllableFirstLetter === mb_strtoupper($nextSyllableFirstLetter)
            ) {
                $currentWord .= " ${nextSyllable} ";
                $remaining = mb_substr($remaining, mb_strlen($nextSyllable));
                continue;
            }

            array_push($elements, new PinyinWord(trim($currentWord)));
            $currentWord = '';
            $remaining = mb_substr($remaining, mb_strlen($nextSyllable));
        }

        return $words;
    }

    public function __toString(): string
    {
        return $this->sentence;
    }
}
