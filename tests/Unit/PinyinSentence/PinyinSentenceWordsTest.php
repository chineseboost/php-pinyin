<?php

namespace Pinyin\Tests\Unit\PinyinSentence;

use PHPUnit\Framework\TestCase;
use Pinyin\PinyinSentence;

class PinyinSentenceWordsTest extends TestCase
{
    /**
     * @dataProvider wordsProvider
     *
     * @param string   $sentence
     * @param string[] $expectedWords
     */
    public function testWords(string $sentence, array $expectedWords): void
    {
        // Given we have a pinyin sentence;
        $pinyinSentence = new PinyinSentence($sentence);

        // When we get its individual pinyin words;
        $words = $pinyinSentence->words();

        // Then we should get the correct words.
        self::assertCount(
            count($expectedWords),
            $words,
            sprintf(
                '"%s" should have %d words ("%s"), got %d ("%s")',
                $sentence,
                count($expectedWords),
                implode('","', $expectedWords),
                count($words),
                implode('","', $words)
            )
        );
        foreach ($expectedWords as $i => $expectedWord) {
            self::assertSame(
                (string) $expectedWord,
                (string) ($words[$i]),
                sprintf(
                    '#%d word of "%s" should be "%s", got "%s" ("%s")',
                    $i,
                    $sentence,
                    $expectedWord,
                    $words[$i],
                    implode('","', $words)
                )
            );
        }
    }

    /**
     * @return array[]
     */
    public function wordsProvider(): array
    {
        return [
            ['Wo3 yao4 qu4 Bei3jing1 le', ['Wo3', 'yao4', 'qu4', 'Bei3jing1', 'le']],
            ['Wo3yao4qu4Bei3jing1le', ['Wo3yao4qu4', 'Bei3jing1le']],
            ['Wǒ yào qù Běijīng le', ['Wǒ', 'yào', 'qù', 'Běijīng', 'le']],
            ['WǒyàoqùBěijīngle', ['Wǒyàoqù', 'Běijīngle']],
            ['ZhōngguóRénmínGònghéguó', ['Zhōngguó', 'Rénmín', 'Gònghéguó']],
            ['1998nián', ['yī', 'jiǔ', 'jiǔ', 'bā', 'nián']],
            [
                'Xué ér shí xí zhī, bù yì yuè hū?',
                ['Xué', 'ér', 'shí', 'xí', 'zhī', 'bù', 'yì', 'yuè', 'hū'],
            ],
            [
                'Yǒu péng zì yuǎnfāng lái, bù yì lè hū?',
                ['Yǒu', 'péng', 'zì', 'yuǎnfāng', 'lái', 'bù', 'yì', 'lè', 'hū'],
            ],
            [
                'Yīxiē shìqíng wǒmen néng kòngzhì, lìng yīxiē zé bù néng.',
                ['Yīxiē', 'shìqíng', 'wǒmen', 'néng', 'kòngzhì', 'lìng', 'yīxiē', 'zé', 'bù', 'néng'],
            ],
        ];
    }
}
