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
     * @param string $word
     * @param int    $syllableLimit
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
    public function elements(): array
    {
        $elements = [];
        $remaining = $this->word;

        for ($i = 0; mb_strlen($remaining) > 0 && $i < $this->syllableLimit; $i++) {
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

            array_push($elements, new PinyinSyllable($nextSyllable));
            $remaining = mb_substr($remaining, mb_strlen($nextSyllable));
        }

        return $elements;
    }

    public function normalized(): Normalizing
    {
        $toneMarked = PinyinTone::isToneMarked($this->word);

        return new self(
            PinyinRegex::normalize(
                implode(
                    '',
                    array_map(
                        function (Normalizing $element) use ($toneMarked): string {
                            if ($toneMarked && $element instanceof PinyinSyllable) {
                                return $element->toneMarked();
                            }

                            return $element->normalized();
                        },
                        $this->elements()
                    )
                )
            )
        );
    }

    public function __toString(): string
    {
        return $this->word;
    }
}
