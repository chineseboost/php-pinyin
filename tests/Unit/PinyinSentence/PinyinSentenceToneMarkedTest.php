<?php

namespace Pinyin\Tests\Unit\PinyinSentence;

use PHPUnit\Framework\TestCase;
use Pinyin\PinyinSentence;

class PinyinSentenceToneMarkedTest extends TestCase
{
    /**
     * @dataProvider toneMarkedProvider
     *
     * @param string $subject
     * @param string $expectedToneMarked
     */
    public function testToneMarked(string $subject, string $expectedToneMarked): void
    {
        // Given a pinyin sentence;
        $sentence = new PinyinSentence($subject);

        // When we apply pinyin tone marks to it;
        $toneMarked = $sentence->toneMarked();

        // Then pinyin tone marks should be correctly applied.
        self::assertSame($expectedToneMarked, (string) $toneMarked);
    }

    /**
     * @return array[]
     */
    public function toneMarkedProvider(): array
    {
        return [
            ['', ''],
            ['Ta1 zen3me hai2 mei2 xia4lai2 ne?', 'Tā zěnme hái méi xiàlái ne?'],
            [
                'Cong2 bāshi2 lóu ke3yǐ kan4 dào zheng3gè cheng2shì, zan2men0 shang4qù kan4 yīxia4 ba5.',
                'Cóng bāshí lóu kěyǐ kàn dào zhěnggè chéngshì, zánmen shàngqù kàn yīxià ba.',
            ],
        ];
    }
}
