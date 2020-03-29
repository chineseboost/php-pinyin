<?php

namespace Pinyin\Tests\Unit\Hanzi\Conversion;

use PHPUnit\Framework\TestCase;
use Pinyin\Hanzi\Conversion\FurthestForwardMatching;

class FurthestForwardMatchingTest extends TestCase
{
    /**
     * @dataProvider furthestForwardMatchingProvider
     *
     * @param string $hanzi
     * @param string $expectedPinyin
     */
    public function testFurthestForwardMatching(string $hanzi, string $expectedPinyin): void
    {
        // Given a hanzi string;

        // When we convert it to pinyin with furthest forward matching;
        $converter = new FurthestForwardMatching();
        $pinyin = $converter->convertHanziToPinyin($hanzi);

        // Then we should get the correct pinyin conversion.
        self::assertSame(
            $expectedPinyin,
            (string) $pinyin,
            sprintf(
                '"%s" should convert to "%s", got "%s".',
                $hanzi,
                $expectedPinyin,
                (string) $pinyin
            )
        );
    }

    /**
     * @return array[]
     */
    public function furthestForwardMatchingProvider(): array
    {
        return [
            ['你好', 'Ni3hao3'],
            ['旅游', 'Lv3you2'],
            ['旅遊', 'Lv3you2'],
            ['旅行', 'Lv3xing2'],
            ['行业', 'Hang2ye4'],
            ['绿色', 'Lv4se4'],
            ['加以', 'Jia1yi3'],
            ['走！', 'Zou3!'],
            ['要～～', 'Yao4!'],
            ['我得去看看。', 'Wo3 dei3 qu4 kan4kan5.'],
            ['你必须得去！', 'Ni3 bi4xu1 dei3 qu4!'],
            ['中华人民共和国', 'Zhong1hua2 Ren2min2 Gong4he2guo2'],
            ['中国全名为中华人民共和国', 'Zhong1guo2 quan2 ming2 wei2 Zhong1hua2 Ren2min2 Gong4he2guo2'],
            [
                '科学家的工作就是对理论加以检验。',
                'Ke1xue2jia1 de5 gong1zuo4 jiu4shi4 dui4 li3lun4 jia1yi3 jian3yan4.',
            ],
            ['加以检验', 'Jia1yi3 jian3yan4'],
            [
                '政府必须对枪支的买卖加以限制。',
                'Zheng4fu3 bi4xu1 dui4 qiang1zhi1 de5 mai3mai4 jia1yi3 xian4zhi4.',
            ],
            [
                '讨论这个问题的时候，应该对这两个概念加以区别。',
                'Tao3lun4 zhe4ge5 wen4ti2 de5 shi2hou5, ying1gai1 dui4 zhe4 liang3 ge4 gai4nian4 jia1yi3 qu1bie2.'
            ],
            [
                '猫（学名：Felis Catus或Felis silvestris catus），通常指家猫，为小型猫科动物。',
                'Mao1 (xue2ming2: Felis Catus huo4 Felis silvestris catus), tong1chang2 zhi3 jia1 mao1, wei2 xiao3xing2 mao1 ke1 dong4wu4.'
            ],
//            [
//                '政府将在2015年对旅游行业加以规范。',
//                'Zheng4fu3 jiang1 zai4 er4 ling2 yi1 wu3 nian2 dui4 lv3you2 hang2ye4 jia1yi3 gui1fan4.'
//            ]
        ];
    }
}
