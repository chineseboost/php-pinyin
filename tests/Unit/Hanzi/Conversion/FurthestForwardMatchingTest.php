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
            ['食品供给', 'Shi2pin3 gong1ji3'],
            ['雪花落在树上', 'Xue3hua1 luo4 zai4 shu4 shang4'],
            ['我把要是落在家里了。', 'Wo3 ba3 yao4shi5 la4 zai4jia1 li3 le5.'],
            ['叶子落了。', 'Ye4zi5 luo4 le5.'],
            ['贵得不得了', 'Gui4 de5 bu4de2liao3'],
            ['飞机要着陆了。', 'Fei1ji1 yao4 zhuo2lu4 le5.'],
            ['他的心情很失落。', 'Ta1 de5 xin1qing2 hen3 shi1luo4.'],
            ['书架上落了灰。', 'Shu1jia4 shang4 luo4 le5 hui1.'],
            ['他很能干。', 'Ta1 hen3 neng2gan4.'],
            ['超级干燥', 'Chao1ji2 gan1zao4'],
            ['都好了。', 'Dou1 hao3 le5.'],
            ['长城', 'Chang2cheng2'],
            ['李校长的头发很长', 'Li3 xiao4zhang3 de5 tou2fa5 hen3 chang2'],
            ['我有朝一日会去朝鲜', 'Wo3 you3 chao2 yi1 ri4 hui4 qu4 Chao2xian3'],
            ['茶匙跟钥匙不一样', 'Cha2chi2 gen1 yao4shi5 bu4yi1yang4'],
            ['大夫', 'Dai4fu5'],
            ['北京首都国际机场', 'Bei3jing1 Shou3du1 Guo2ji4 Ji1chang3'],
            ['中华人民共和国', 'Zhong1hua2 Ren2min2 Gong4he2guo2'],
            ['中国全名为中华人民共和国', 'Zhong1guo2 quan2 ming2 wei2 Zhong1hua2 Ren2min2 Gong4he2guo2'],
            ['我快快地做饭', 'Wo3 kuai4 kuai4 de5 zuo4fan4'],
            ['一块地', 'Yi1 kuai4 di4'],
            ['一点儿都没有', 'Yi1dianr3 dou1 mei2you3'],
            ['一點兒都沒有', 'Yi1dianr3 dou1 mei2you3'],
            ['劲儿', 'Jinr4'],
            ['勁兒', 'Jinr4'],
            ['这种酒劲儿大', 'Zhe4zhong3 jiu3 jinr4 da4'],
            ['這種酒勁兒大', 'Zhe4zhong3 jiu3 jinr4 da4'],
            ['儿子', 'Er2zi5'],
            ['兒子', 'Er2zi5'],
            ['女儿', "Nv3'er2"],
            ['女兒', "Nv3'er2"],
            ['这块儿', 'Zhe4 kuair4'],
            ['這塊兒', 'Zhe4 kuair4'],
            ['哪儿', 'Nar3'],
            ['把儿', 'Bar3'],
            ['伴儿', 'Banr4'],
            ['盖儿', 'Gair4'],
            ['妹儿', 'Meir4'],
            ['份儿', 'Fenr4'],
            ['趟儿', 'Tangr4'],
            ['气儿', 'Qir4'],
            ['劲儿', 'Jinr4'],
            ['裙儿', 'Qunr2'],
            ['驴儿', 'Lvr2'],
            ['只有', 'Zhi3you3'],
            ['骰子', 'Shai3zi5'],
            ['色子', 'Shai3zi5'],
            ['那', 'Na4'],
            ['一瓶儿', 'Yi1 pingr2'],
            ['公园儿', 'Gong1yuanr2'],
            ['小孩儿', 'Xiao3hair2'],
            ['事儿', 'Shir4'],
            ['板儿砖', 'Banr3 zhuan1'],
            ['哪兒', 'Nar3'],
            ['把兒', 'Bar3'],
            ['伴兒', 'Banr4'],
            ['蓋兒', 'Gair4'],
            ['妹兒', 'Meir4'],
            ['份兒', 'Fenr4'],
            ['趟兒', 'Tangr4'],
            ['氣兒', 'Qir4'],
            ['勁兒', 'Jinr4'],
            ['裙兒', 'Qunr2'],
            ['驢兒', 'Lvr2'],
            ['一瓶兒', 'Yi1 pingr2'],
            ['公園兒', 'Gong1yuanr2'],
            ['小孩兒', 'Xiao3hair2'],
            ['事兒', 'Shir4'],
            ['板兒磚', 'Banr3 zhuan1'],
            ['好玩儿', 'Hao3wanr2'],
            ['西藏', 'Xi1zang4'],
            ['西安', "Xi1'an1"],
            ['天峨', "Tian1'e2"],
            ['彼岸消失了，脚下也不稳。', "Bi3'an4 xiao1shi1 le5, jiao3 xia4 ye3 bu4 wen3."],
            ['母亲安抚着她在哭的婴儿', "Mu3qin1 an1fu3 zhe5 ta1 zai4 ku1 de5 ying1'er2"],
            ['一个人藏，十个人找。', 'Yi1 ge5 ren2 cang2, shi2 ge5 ren2 zhao3.'],
            ['他这么快地把工作做完', 'Ta1 zhe4me5 kuai4 de5 ba3 gong1zuo4 zuo4 wan2'],
            ['“还要咖啡吗？”“不了，谢谢。”', '“Hai2yao4 ka1fei1 ma5?” “Bu4le5, xie4xie5.”'],
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
                'Tao3lun4 zhe4ge5 wen4ti2 de5 shi2hou5, ying1gai1 dui4 zhe4 liang3 ge4 gai4nian4 jia1yi3 qu1bie2.',
            ],
            [
                '猫（学名：Felis Catus或Felis silvestris catus），通常指家猫，为小型猫科动物。',
                'Mao1 (xue2ming2: Felis Catus huo4 Felis silvestris catus), tong1chang2 zhi3 jia1 mao1, wei2 xiao3xing2 mao1 ke1 dong4wu4.',
            ],
            [
                '政府将在2015年对旅游行业加以规范。',
                'Zheng4fu3 jiang1 zai4 er4 ling2 yi1 wu3 nian2 dui4 lv3you2 hang2ye4 jia1yi3 gui1fan4.',
            ],
        ];
    }
}
