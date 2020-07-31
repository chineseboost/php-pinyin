<?php

namespace Pinyin\Hanzi;

use Pinyin\String\HtmlAble;
use Pinyin\String\Stringable;

class NonHanziString implements Stringable, HtmlAble
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

    public function asHtml(): string
    {
        return trim(
            <<<HTML
<span class="non-hanzi">{$this->string}</span>
HTML
        );
    }

    public function __toString(): string
    {
        return $this->string;
    }
}
