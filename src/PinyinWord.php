<?php

namespace Pinyin;

use Pinyin\String\Normalizing;

class PinyinWord implements Normalizing
{
    /** @var string */
    protected $word;

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

    public function toneMarked(): self
    {
        return new static(
            implode(
                '',
                array_map(
                    static function (Normalizing $element): Normalizing {
                        if ($element instanceof PinyinSyllable) {
                            return $element->toneMarked();
                        }

                        return $element;
                    },
                    $this->elements()
                )
            )
        );
    }

    /**
     * @return PinyinSyllable[]
     */
    public function syllables(): array
    {
        return array_values(
            array_filter(
                $this->elements(),
                static function (Normalizing $stringable): bool {
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
        $remaining = preg_replace('/\s+/u', ' ', trim($this->word));
        $remaining = PinyinYear::replaceYears($remaining);

        for ($i = 0; $remaining !== '' && $i < $this->syllableLimit; $i++) {
            $nextSyllable = PinyinRegex::extractFirstSyllable($remaining);
            if (!$nextSyllable) {
                if ($remaining !== '') {
                    $elements[] = new NonPinyinString($remaining);
                }
                break;
            }

            $nextSyllablePos = mb_strpos($remaining, $nextSyllable);
            if ($nextSyllablePos !== 0) {
                $nonSyllable = mb_substr($remaining, 0, $nextSyllablePos);
                $elements[] = new NonPinyinString($nonSyllable);
                $remaining = mb_substr($remaining, mb_strlen($nonSyllable));
                continue;
            }

            $elements[] = new PinyinSyllable($nextSyllable);
            $remaining = mb_substr($remaining, mb_strlen($nextSyllable));
        }

        return $elements;
    }

    public function normalized(): Normalizing
    {
        $toneMarked = PinyinTone::isToneMarked($this->word);

        return new static(
            PinyinRegex::normalize(
                implode(
                    '',
                    array_map(
                        static function (Normalizing $element) use ($toneMarked): string {
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
