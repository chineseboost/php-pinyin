<?php

namespace Pinyin\Hanzi\Conversion;

use Pinyin\PinyinSentence;

interface HanziPinyinConversionStrategy
{
    public function convertHanziToPinyin(string $hanzi): PinyinSentence;
}
