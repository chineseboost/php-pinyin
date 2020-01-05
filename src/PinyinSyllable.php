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
     * @param  string  $syllable
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
        return new PinyinSyllable(PinyinTone::applyToneMark(
            (string) $this->plain(),
            $this->tone()->number()
        ));
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
        mb_internal_encoding('UTF-8');
        $syllable = PinyinRegex::extractFirstSyllable((string) $this->syllable);
        $syllable = preg_replace('/v/u', 'ü', $syllable, 1);
        $syllable = preg_replace('/V/u', 'Ü', $syllable, 1);

        $firstLetter = mb_substr($syllable, 0, 1);
        if ($firstLetter === mb_strtoupper($firstLetter)) {
            $syllable =
                sprintf(
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
        mb_internal_encoding('UTF-8');
        $plain = (string) $this->normalized();
        $plain = preg_replace('/[0-9]+/u', '', $plain);
        foreach (PinyinTone::VOWEL_MARKS as $unmarkedVowel => $toneMarked) {
            foreach (array_values($toneMarked) as $markedVowel) {
                $plain = preg_replace(
                    sprintf("/%s/u", $markedVowel),
                    $unmarkedVowel,
                    $plain
                );
                $plain = preg_replace(
                    sprintf('/%s/u', mb_strtoupper($markedVowel)),
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
