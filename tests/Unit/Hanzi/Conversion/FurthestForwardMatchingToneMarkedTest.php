<?php

namespace Pinyin\Tests\Unit\Hanzi\Conversion;

use PHPUnit\Framework\TestCase;
use Pinyin\Hanzi\Conversion\FurthestForwardMatching;

class FurthestForwardMatchingToneMarkedTest extends TestCase
{
    /**
     * @dataProvider furthestForwardMatchingToneMarkedProvider
     *
     * @param string $hanzi
     * @param string $expectedToneMarked
     */
    public function testFurthestForwardMatchingToneMarked(
        string $hanzi,
        string $expectedToneMarked
    ): void {
        // Given a hanzi string;

        // When we convert it to pinyin with furthest forward matching;
        $converter = new FurthestForwardMatching();
        $pinyin = $converter->convertHanziToPinyin($hanzi);

        // And then get it tone marked;
        $toneMarked = $pinyin->toneMarked();

        // Then we should get the correct pinyin conversion.
        self::assertSame(
            $expectedToneMarked,
            (string) $toneMarked,
            sprintf(
                '"%s" should convert to "%s", got "%s".',
                $hanzi,
                $expectedToneMarked,
                (string) $toneMarked
            )
        );
    }

    /**
     * @return array[]
     */
    public function furthestForwardMatchingToneMarkedProvider(): array
    {
        return [
            [
                '科学家的工作就是对理论加以检验。',
                'Kēxuéjiā de gōngzuò jiùshì duì lǐlùn jiāyǐ jiǎnyàn.',
            ],
            [
                '他下了车，扑哧扑哧地穿过泥地去开门。',
                'Tā xià le chē, pū chī pū chī de chuānguò ní dì qù kāimén.',
            ],
            [
                '我兒子真的是一點兒生活常識都沒有！',
                'Wǒ érzi zhēn de shì yīdiǎnr shēnghuó chángshí dōu méiyǒu!',
            ],
            [
                '政府将在2015年对旅游行业加以规范。',
                'Zhèngfǔ jiāng zài èr líng yī wǔ nián duì lǚyóu hángyè jiāyǐ guīfàn.',
            ],
            [
                '食品供给',
                'Shípǐn gōngjǐ',
            ],
            [
                '我已经累得不得了了。',
                'Wǒ yǐjīng lèi de bùdéliǎo le.',
            ],
            [
                '你想吃苹果吗？',
                'Nǐ xiǎng chī píngguǒ ma?',
            ],
            [
                '商业是联结生产同消费的桥梁。',
                'Shāngyè shì liánjié shēngchǎn tóng xiāofèi de qiáoliáng.',
            ],
        ];
    }
}
