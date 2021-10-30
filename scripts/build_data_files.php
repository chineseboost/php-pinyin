<?php

mb_internal_encoding('UTF-8');

$ceDictPath = '/tmp/cedict_1_0_ts_utf-8_mdbg.txt.gz';
if (!is_file($ceDictPath)) {
    copy(
        'https://www.mdbg.net/chinese/export/cedict/cedict_1_0_ts_utf-8_mdbg.txt.gz',
        $ceDictPath
    );
}

$wordFreqPath = '/tmp/global_wordfreq.release_UTF-8.txt';
if (!is_file($wordFreqPath)) {
    copy(
        'https://s3.amazonaws.com/files.chineseboost.com/BCC_LEX_Zh/global_wordfreq.release_UTF-8.txt',
        $wordFreqPath
    );
}

$commonWords = [];
$wordFreqFile = fopen($wordFreqPath, 'rb');
while (($freqRow = fgetcsv($wordFreqFile, 1000, '	')) !== false) {
    if (mb_strlen($freqRow[0]) < 2) {
        continue;
    }
    $commonWords[$freqRow[0]] = true;
    if (count($commonWords) >= 200000) {
        break;
    }
}
fclose($wordFreqFile);
printf("Loaded %d common words\n", count($commonWords));

/** @noinspection PhpComposerExtensionStubsInspection */
$ceDictFile = gzopen($ceDictPath, 'r');

$exportFiles = [];
$seen = [];

/**
 * "Forces" alter incoming data from MDBG etc. and override what gets written
 * to the main data files for a given source word.
 */
$forces = [
    '要'  => 'yao4',
    '了'  => 'le5',
    '上'  => 'shang4',
    '落'  => 'luo4',
    '得'  => 'de5',
    '都'  => 'dou1',
    '大夫' => 'Dai4fu5',
    '盖'  => 'gai4',
    '趟'  => 'tang4',
    '地'  => 'di4',
    '累'  => 'lei4',
    '吗'  => 'ma5',
    '嗎'  => 'ma5',
    '同'  => 'tong2',
    '都会' => 'dou1 hui4',
    '番'  => 'fan1',
    '轉'  => 'zhuan3',
    '打'  => 'da3',
    '那'  => 'na4',
    '着'  => 'zhe5',
    '藏'  => 'cang2',
    '骰子' => 'shai3zi5',
];

while ($line = stream_get_line($ceDictFile, 1024 * 1024, "\n")) {
    if (mb_strpos($line, '#') === 0) {
        continue;
    }

    preg_match('/([\p{Han}]+) ([\p{Han}]+) \[([a-zA-Z0-9: ]+)]/u', $line, $matches);
    if (count($matches) < 4) {
        continue;
    }

    [, $fanti, $jianti, $pinyin] = $matches;
    if ($pinyin === 'xx') {
        continue;
    }

    if (mb_strlen($pinyin) < 2) {
        continue;
    }

    $hanziLength = mb_strlen($fanti);
    if ($hanziLength >= 2 && !isset($commonWords[$jianti])) {
        continue;
    }
    if ($hanziLength > 3) {
        $firstChar = mb_substr($pinyin, 0, 1);
        if ($firstChar !== mb_strtoupper($firstChar)) {
            continue;
        }
    }
    if (isset($seen[$fanti], $seen[$jianti])) {
        continue;
    }

    $seen[$fanti] = true;
    $seen[$jianti] = true;

    $pinyin = preg_replace('/u:/u', 'v', $pinyin);
    $pinyin = $forces[$jianti] ?? $forces[$fanti] ?? preg_replace('/\s+([^A-Z])/u', '$1', $pinyin);
    $pinyin = preg_replace('/([0-5])\s*r5/u', 'r$1', $pinyin);
    $pinyin = preg_replace('/([0-5])([aeiou])/ui', "$1\'$2", $pinyin);

    if ($hanziLength === 1) {
        $pinyin = mb_strtolower($pinyin);
    }

    $lengthKey = sprintf('%02d', $hanziLength);
    if (!isset($exportFiles[$lengthKey])) {
        $filePath = implode(
            DIRECTORY_SEPARATOR,
            [__DIR__, '..', 'data', "{$lengthKey}_pinyin.data"]
        );
        $exportFiles[$lengthKey] = fopen($filePath, 'wb');
        fwrite($exportFiles[$lengthKey], '<?php return [');
    }

    fwrite($exportFiles[$lengthKey], "'$fanti'=>'$pinyin',");

    if ($jianti !== $fanti) {
        fwrite($exportFiles[$lengthKey], "'$jianti' => '$pinyin',");
    }
}

printf("Wrote %d data files\n", count($exportFiles));

/**
 * "Tweaks", pronouns, punctuation etc. get added to main data files in addition
 * to source words.
 */
$basicTweaks = [
    '必须得' => 'bi4xu1 dei3',
    '取得'  => 'qu3de2',
    '说乎'  => 'yue4 hu1',
    '說乎'  => 'yue4 hu1',
    '亦说'  => 'yi4 yue4',
    '亦說'  => 'yi4 yue4',
    '睡着'  => 'shui4zhao2',
];
$pronouns = [
    '我' => 'wo3',
    '你' => 'ni3',
    '您' => 'nin2',
    '他' => 'ta1',
    '她' => 'ta1',
    '它' => 'ta1',
    '牠' => 'ta1',
    '祂' => 'ta1',
    '谁' => 'shei2',
    '誰' => 'shei2',
];
foreach ($pronouns as $pronoun => $pronounPinyin) {
    $basicTweaks["{$pronoun}得"] = "$pronounPinyin dei3";
    $basicTweaks["{$pronoun}们得"] = "$pronounPinyin dei3";
}

$numerals = [
    '一',
    '二',
    '三',
    '四',
    '五',
    '六',
    '七',
    '八',
    '九',
    '十',
    '百',
    '千',
    '万',
    '亿',
];

$punctuation = [
    '。'  => '. ',
    '？'  => '? ',
    '！'  => '! ',
    '，'  => ', ',
    '、'  => ', ',
    '；'  => '; ',
    '：'  => ': ',
    '「'  => '“',
    '」'  => '”',
    '﹁'  => '“',
    '﹂'  => '”',
    '『'  => '“',
    '』'  => '”',
    '《'  => '“',
    '》'  => '”',
    '〈'  => '“',
    '〉'  => '”',
    '（'  => ' (',
    '）'  => ') ',
    '［'  => ' [',
    '］'  => '] ',
    '【'  => ' [',
    '】'  => '] ',
    '‧'  => ' ',
    '…'  => ' ... ',
    '……' => ' ... ',
    '—'  => ' — ',
    '——' => ' — ',
    '～'  => ' — ',
    '～～' => '! ',
    '　'  => ' ',
];
foreach (array_merge($basicTweaks, $punctuation) as $zhongWen => $pinyinConversion) {
    if ($zhongWen === $pinyinConversion) {
        continue;
    }
    if (isset($seen[$zhongWen])) {
        continue;
    }
    $lengthKey = sprintf('%02d', mb_strlen($zhongWen));
    fwrite($exportFiles[$lengthKey], "'$zhongWen'=>'$pinyinConversion',");
}

/**
 * "Regex tweaks" go in a special regex tweaks data file that gets applied
 * globally on a whole hanzi string first before furthest-forward matching is
 * applied to the rest.
 */
$regexTweaks = [
    sprintf(
        '/(%s[们們]?)([把将])(.{1,20})落/u',
        implode('|', array_keys($pronouns))
    )                       => '$1$2$3 la4',
    '/得([不得]?)到/u'          => 'de2$1dao4',
    '/(.{1,2})\1{1}地/u'     => '$1$1 de5',
    '/([么|麽].)地/u'          => '$1 de5',
    '/([一|两|那|这|這|此].)地/u'  => '$1 di4',
    '/不([\p{Han}]{1,4})地/u' => 'bu4 $1 de5',
    sprintf(
        '/(%s)+个/u',
        implode('|', $numerals)
    )                       => '$1 ge5',
];
$tweaksFilePath = implode(
    DIRECTORY_SEPARATOR,
    [__DIR__, '..', 'data', 'tweaks_pinyin.data']
);
$tweaksFile = fopen($tweaksFilePath, 'wb');
fwrite($tweaksFile, '<?php return [');
foreach ($regexTweaks as $regex => $tweak) {
    fwrite($tweaksFile, "'$regex'=>'$tweak',");
}

foreach (array_merge($exportFiles, [$tweaksFile]) as $exportFile) {
    fwrite($exportFile, '];');
    $fileName = stream_get_meta_data($exportFile)['uri'];
    $fileSize = filesize($fileName) / 1000;
    fclose($exportFile);
    printf("%s\t%d kb\n", $fileName, $fileSize);
}
