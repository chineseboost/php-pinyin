<?php

namespace Pinyin;

/**
 * Class PinyinFinal.
 */
class PinyinFinal
{
    const FINALS = [
        'iong',
        'iang',
        'ueng',
        'uang',
        'ian',
        'iao',
        'uai',
        'uan',
        'ong',
        'eng',
        'ing',
        'üan',
        'van',
        'ang',
        'un',
        'üe',
        'ui',
        'ün',
        've',
        'uo',
        'ua',
        'vn',
        'ou',
        'ai',
        'in',
        'iu',
        'ie',
        'ia',
        'er',
        'en',
        'an',
        'ao',
        'ei',
        'o',
        'e',
        'a',
        'v',
        'ü',
        'u',
        'i',
    ];

    /** @var string */
    private $final;

    /**
     * @param string $final
     */
    public function __construct(string $final)
    {
        $this->final = trim($final);
    }

    public function __toString()
    {
        return $this->final;
    }
}
