<?php

namespace Pinyin;

use Pinyin\String\HtmlAble;
use Pinyin\String\Normalizing;

class NonPinyinString implements Normalizing, HtmlAble
{
    /** @var string */
    private $string;

    /**
     * @param string $string
     */
    public function __construct(string $string)
    {
        $this->string = $string;
    }

    public function normalized(): Normalizing
    {
        return new static(preg_replace('/\s+/u', ' ', PinyinRegex::normalize($this->string)));
    }

    public function asHtml(): string
    {
        return trim(
            <<<HTML
<span class="non-pinyin">{$this->string}</span>
HTML
        );
    }

    public function __toString(): string
    {
        return $this->string;
    }
}
