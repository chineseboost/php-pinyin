<?php

namespace Pinyin;

use Pinyin\String\Normalizing;

class PinyinWord implements Normalizing
{
    /** @var string */
    private $word;

    /** @var int */
    private $syllableLimit;

    /**
     * @param  string  $word
     * @param  int  $syllableLimit
     */
    public function __construct(string $word, int $syllableLimit = 100)
    {
        $this->word = $word;
        $this->syllableLimit = $syllableLimit;
    }

    /**
     * @return PinyinSyllable[]
     */
    public function syllables(): array
    {
        return array_values(
            array_filter(
                $this->elements(),
                function (Normalizing $stringable): bool {
                    return $stringable instanceof PinyinSyllable;
                }
            )
        );
    }

    /**
     * @return Normalizing[]
     */
    private function elements(): array
    {
        $elements = [];
        $remaining = $this->word;

        for ($i = 0; mb_strlen($remaining) > 0 && $i < $this->syllableLimit; $i++) {
            $nextSyllable = PinyinRegex::extractFirstSyllable(trim($remaining));
            if (!$nextSyllable) {
                break;
            }

            $nextSyllablePos = mb_strpos($remaining, $nextSyllable);
            if ($nextSyllablePos === 0) {
                array_push($elements, new PinyinSyllable($nextSyllable));
                $remaining = mb_substr($remaining, mb_strlen($nextSyllable));
            } else {
                $nonSyllable = mb_substr($remaining, 0, $nextSyllablePos);
                array_push($elements, new NonPinyinString($nonSyllable));
                $remaining = mb_substr($remaining, mb_strlen($nonSyllable));
            }
        }

        return $elements;
    }

    public function normalized(): Normalizing
    {
        return new PinyinWord(
            implode(
                '',
                array_map(
                    function (Normalizing $element): string {
                        return (string) $element->normalized();
                    },
                    $this->elements()
                )
            )
        );
    }

    public function __toString(): string
    {
        return $this->word;
    }
}
