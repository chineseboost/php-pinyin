<?php

namespace Pinyin;

use Pinyin\String\HtmlAble;
use Pinyin\String\Normalizing;
use Pinyin\String\Stringable;

class PinyinSyllable implements Stringable, Normalizing, HtmlAble
{
    /**
     * @var string
     */
    private $syllable;

    /**
     * @param string $syllable
     */
    public function __construct(string $syllable)
    {
        $this->syllable = $syllable;
    }

    public function pinyinInitial(): PinyinInitial
    {
        return new PinyinInitial(PinyinRegex::extractFirstInitial($this->normalized()));
    }

    public function pinyinFinal(): PinyinFinal
    {
        return new PinyinFinal(PinyinRegex::extractFirstFinal($this->normalized()));
    }

    /**
     * @return PinyinTone
     */
    public function tone(): PinyinTone
    {
        return PinyinTone::fromPinyinSyllable($this);
    }

    /**
     * https://en.wikipedia.org/wiki/Pinyin#Rules_for_placing_the_tone_mark.
     *
     * @return PinyinSyllable
     */
    public function toneMarked(): self
    {
        return new static(PinyinTone::applyToneMark(
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

        return new static("${plain}${toneNumber}");
    }

    public function normalized(): Normalizing
    {
        mb_internal_encoding('UTF-8');
        $syllable = PinyinRegex::extractFirstSyllable((string) $this->syllable);

        foreach (PinyinRegex::NORMALIZATIONS as $pattern => $replacement) {
            $syllable = preg_replace($pattern, $replacement, $syllable);
        }

        $firstLetter = mb_substr($syllable, 0, 1);
        if ($firstLetter === mb_strtoupper($firstLetter)) {
            $syllable =
                sprintf(
                    '%s%s',
                    mb_strtoupper($firstLetter),
                    mb_strtolower(mb_substr($syllable, 1))
                );
        } else {
            $syllable = mb_strtolower($syllable);
        }

        if (PinyinTone::isToneMarked($syllable)) {
            $syllable = preg_replace('/[0-5]+/u', '', $syllable);
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
        $plain = preg_replace('/[0-5]+/u', '', $plain);
        $plain = PinyinTone::stripToneMarks($plain);

        return new static($plain);
    }

    public function isToneMarked(): bool
    {
        return PinyinTone::isToneMarked($this->syllable);
    }

    public function asHtml(): string
    {
        return trim(
            <<<HTML
<span class="pinyin pinyin-syllable pinyin-tone-{$this->tone()->number()}"
lang="zh-Latn-CN-pinyin">{$this->toneMarked()}</span>
HTML
        );
    }

    public function hanziCount(): int
    {
        if (preg_match('/r[0-5]?$/i', $this->syllable)) {
            return 2;
        }

        return 1;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->syllable;
    }
}
