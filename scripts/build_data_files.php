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
while (($freqRow = fgetcsv($wordFreqFile, 1000, '	')) !== FALSE) {
    if (mb_strlen($freqRow[0]) < 2) {
        continue;
    }
    $commonWords[$freqRow[0]] = true;
    if (count($commonWords) >= 60000) {
        break;
    }
}
fclose($wordFreqFile);
printf("Loaded %d common words\n", count($commonWords));

/** @noinspection PhpComposerExtensionStubsInspection */
$ceDictFile = gzopen($ceDictPath, 'r');

$exportFiles = [];
$seen = [];

while ($line = stream_get_line($ceDictFile, 1024 * 1024, "\n")) {
    if (mb_strpos($line, '#') === 0) {
        continue;
    }

    preg_match('/([\p{Han}]+) ([\p{Han}]+) \[([a-zA-Z0-9 ]+)]/u', $line, $matches);
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

    $pinyin = preg_replace('/\s+([^A-Z])/u', '$1', $pinyin);

    $lengthKey = sprintf('%02d', $hanziLength);
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

printf("Wrote %d data files\n", count($exportFiles));

foreach ($exportFiles as $exportFile) {
    fwrite($exportFile, '];');
    $fileName = stream_get_meta_data($exportFile)['uri'];
    $fileSize = filesize($fileName) / 1000;
    fclose($exportFile);
    printf("%s\t%d kb\n", $fileName, $fileSize);
}