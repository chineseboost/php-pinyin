<?php

namespace Pinyin\Tests\Unit\PinyinSentence;

use PHPUnit\Framework\TestCase;
use Pinyin\PinyinSentence;

class PinyinSentenceSyllablesTest extends TestCase
{
    /**
     * @dataProvider syllablesProvider
     *
     * @param string $sentence
     * @param array  $expectedSyllables
     */
    public function testSyllables(string $sentence, array $expectedSyllables): void
    {
        // Given a pinyin sentence;
        $pinyinSentence = new PinyinSentence($sentence);

        // When we get the individual syllables;
        $syllables = $pinyinSentence->syllables();

        // Then we should get the correct syllables.
        self::assertCount(
            count($expectedSyllables),
            $syllables,
            sprintf(
                "'%s' should have %d syllables ('%s'), got %d ('%s')",
                $sentence,
                count($expectedSyllables),
                implode("','", $expectedSyllables),
                count($syllables),
                implode("','", $syllables)
            )
        );
        foreach ($expectedSyllables as $i => $expectedSyllable) {
            self::assertSame(
                (string) $expectedSyllable,
                (string) ($syllables[$i]),
                sprintf(
                    "#%d syllable of '%s' should be '%s', got '%s' ('%s')",
                    $i,
                    $sentence,
                    $expectedSyllable,
                    $syllables[$i],
                    implode("','", $syllables)
                )
            );
        }
    }

    /**
     * @return array[]
     */
    public function syllablesProvider(): array
    {
        return [
            ['Wo3 yao4 qu4 Bei3jing1 le', ['Wo3', 'yao4', 'qu4', 'Bei3', 'jing1', 'le']],
            ['Wo3yao4qu4Bei3jing1le', ['Wo3', 'yao4', 'qu4', 'Bei3', 'jing1', 'le']],
            ['Wǒ yào qù Běijīng le', ['Wǒ', 'yào', 'qù', 'Běi', 'jīng', 'le']],
            ['WǒyàoqùBěijīngle', ['Wǒ', 'yào', 'qù', 'Běi', 'jīng', 'le']],
            ['ZhōngguóRénmínGònghéguó', ['Zhōng', 'guó', 'Rén', 'mín', 'Gòng', 'hé', 'guó']],
            ['1998nian2', ['yī', 'jiǔ', 'jiǔ', 'bā', 'nián']],
            [
                'Xué ér shí xí zhī, bù yì yuè hū?',
                ['Xué', 'ér', 'shí', 'xí', 'zhī', 'bù', 'yì', 'yuè', 'hū'],
            ],
            [
                'Yǒu péng zì yuǎnfāng lái, bù yì lè hū?',
                ['Yǒu', 'péng', 'zì', 'yuǎn', 'fāng', 'lái', 'bù', 'yì', 'lè', 'hū'],
            ],
            [
                'Yīxiē shìqíng wǒmen néng kòngzhì, lìng yīxiē zé bù néng.',
                [
                    'Yī',
                    'xiē',
                    'shì',
                    'qíng',
                    'wǒ',
                    'men',
                    'néng',
                    'kòng',
                    'zhì',
                    'lìng',
                    'yī',
                    'xiē',
                    'zé',
                    'bù',
                    'néng',
                ],
            ],
        ];
    }
}
