<?php

namespace Pinyin;

use Normalizer;

class PinyinSyllable
{
    /**
     * @var string
     */
    private $syllable;

    /**
     * @var PinyinTone
     */
    private $tone;

    /**
     * @param string $syllable
     */
    public function __construct(string $syllable)
    {
        $this->syllable = $syllable;
    }

    /**
     * @return PinyinTone
     */
    public function tone(): PinyinTone
    {
        if (!$this->tone) {
            $this->tone = PinyinTone::fromPinyinSyllable($this);
        }

        return $this->tone;
    }

    /**
     * https://en.wikipedia.org/wiki/Pinyin#Rules_for_placing_the_tone_mark.
     *
     * @return PinyinSyllable
     */
    public function toneMarked(): self
    {
        $syllable = (string) $this->plain();
        $syllableLower = mb_strtolower($syllable);
        foreach (PinyinTone::VOWEL_MARKS as $vowel => $marks) {
            if (mb_strpos($syllableLower, $vowel) !== false) {
                $marked = mb_ereg_replace(
                    $vowel,
                    $marks[$this->tone()->number()],
                    $syllable
                );
                $marked = mb_ereg_replace(
                    mb_strtoupper($vowel),
                    mb_strtoupper($marks[$this->tone()->number()]),
                    $marked
                );

                return new self($marked);
            }
        }

        return $this;
    }

    public function toneNumbered(): self
    {
        if ($this->tone()->isNeutral()) {
            return $this->plain();
        }

        $plain = $this->plain();
        $toneNumber = $this->tone()->number();

        return new self("${plain}${toneNumber}");
    }

    public function normalized(): self
    {
        $syllable = Normalizer::normalize(trim($this->syllable));
        $syllable = mb_ereg_replace('[^\p{L}0-5]', '', $syllable);
        $syllable = mb_substr($syllable, 0, 6);
        $syllable = mb_ereg_replace('v', 'ü', $syllable);
        $syllable = mb_ereg_replace('V', 'Ü', $syllable);

        $firstLetter = mb_substr($syllable, 0, 1);
        if ($firstLetter === mb_strtoupper($firstLetter)) {
            $syllable = sprintf(
                '%s%s',
                mb_strtoupper($firstLetter),
                mb_strtolower(mb_substr($syllable, 1, mb_strlen($syllable) - 1))
            );
        } else {
            $syllable = mb_strtolower($syllable);
        }

        return new static($syllable);
    }

    /**
     * Get the syllable as a plain normalised string with no tone marks.
     *
     * @return PinyinSyllable
     */
    public function plain(): self
    {
        $plain = (string) $this->normalized();
        $plain = mb_ereg_replace('[0-9]+', '', $plain);
        foreach (PinyinTone::VOWEL_MARKS as $unmarkedVowel => $toneMarked) {
            foreach (array_values($toneMarked) as $markedVowel) {
                $plain = mb_ereg_replace($markedVowel, $unmarkedVowel, $plain);
                $plain = mb_ereg_replace(
                    mb_strtoupper($markedVowel),
                    mb_strtoupper($unmarkedVowel),
                    $plain
                );
            }
        }

        return new static($plain);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->syllable;
    }
}
