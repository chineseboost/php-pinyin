<?php

mb_internal_encoding('UTF-8');

$ceDictPath = '/tmp/cedict_1_0_ts_utf-8_mdbg.txt.gz';

if (!is_file($ceDictPath)) {
    copy(
        'https://www.mdbg.net/chinese/export/cedict/cedict_1_0_ts_utf-8_mdbg.txt.gz',
        $ceDictPath
    );
}

/** @noinspection PhpComposerExtensionStubsInspection */
$ceDictFile = gzopen($ceDictPath, 'r');

$exportFiles = [];
$seen = [];

while ($line = stream_get_line($ceDictFile, 1024 * 1024, "\n")) {
    if (mb_strpos($line, '#') === 0) {
        continue;
    }

    preg_match('/([\p{Han}]+) ([\p{Han}]+) \[([a-zA-Z0-9 ]+)\]/u', $line, $matches);
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
    if (mb_strlen($fanti) > 3) {
        if (mb_strlen($fanti) > 7) {
            continue;
        }
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

    $pinyin = preg_replace('/\s+([^A-Z])/u', '$1', $pinyin);

    $lengthKey = sprintf('%02d', mb_strlen($fanti));
    if (!isset($exportFiles[$lengthKey])) {
        $filePath = __DIR__."/../data/{$lengthKey}_pinyin.php";
        $exportFiles[$lengthKey] = fopen($filePath, 'wb');
        fwrite($exportFiles[$lengthKey], '<?php return [');
    }

    fwrite($exportFiles[$lengthKey], "'{$fanti}'=>'{$pinyin}',");

    if ($jianti !== $fanti) {
        fwrite($exportFiles[$lengthKey], "'{$jianti}'=>'{$pinyin}',");
    }
}

foreach ($exportFiles as $exportFile) {
    fwrite($exportFile, '];');
    fclose($exportFile);
}
