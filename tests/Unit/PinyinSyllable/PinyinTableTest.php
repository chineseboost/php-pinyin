<?php

namespace Pinyin\Tests\Unit\PinyinSyllable;

use PHPUnit\Framework\TestCase;
use Pinyin\PinyinSyllable;

/**
 * https://en.wikipedia.org/wiki/Pinyin_table.
 */
class PinyinTableTest extends TestCase
{
    /**
     * @dataProvider pinyinTableProvider
     *
     * @param string $initial
     * @param string $final
     * @param string $expectedSyllable
     */
    public function testPinyinTable(
        string $initial,
        string $final,
        string $expectedSyllable
    ) {
        // Given an initial and final;

        // When we combine them into a syllable;
        $syllable = new PinyinSyllable("${initial}${final}");

        // Then the normalized syllable should be correct.
        $normalized = (string) $syllable->normalized();
        self::assertSame(
            $expectedSyllable,
            $normalized,
            sprintf(
                '"%s" + "%s" should be "%s", got "%s"',
                $initial,
                $final,
                $expectedSyllable,
                $normalized
            )
        );
    }

    public function pinyinTableProvider()
    {
        $table = [
            'i'    => [
                ''   => 'yi',
                'b'  => 'bi',
                'p'  => 'pi',
                'm'  => 'mi',
                'd'  => 'di',
                't'  => 'ti',
                'n'  => 'ni',
                'l'  => 'li',
                'j'  => 'ji',
                'q'  => 'qi',
                'x'  => 'xi',
                'zh' => 'zhi',
                'ch' => 'chi',
                'sh' => 'shi',
                'r'  => 'ri',
                'z'  => 'zi',
                'c'  => 'ci',
                's'  => 'si',
            ],
            'a'    => [
                ''   => 'a',
                'b'  => 'ba',
                'p'  => 'pa',
                'm'  => 'ma',
                'f'  => 'fa',
                'd'  => 'da',
                't'  => 'ta',
                'n'  => 'na',
                'l'  => 'la',
                'g'  => 'ga',
                'k'  => 'ka',
                'h'  => 'ha',
                'zh' => 'zha',
                'ch' => 'cha',
                'sh' => 'sha',
                'z'  => 'za',
                'c'  => 'ca',
                's'  => 'sa',
            ],
            'o'    => [
                ''  => 'o',
                'b' => 'bo',
                'p' => 'po',
                'm' => 'mo',
                'f' => 'fo',
            ],
            'e'    => [
                ''   => 'e',
                'm'  => 'me',
                'd'  => 'de',
                't'  => 'te',
                'n'  => 'ne',
                'l'  => 'le',
                'g'  => 'ge',
                'k'  => 'ke',
                'h'  => 'he',
                'zh' => 'zhe',
                'ch' => 'che',
                'sh' => 'she',
                'r'  => 're',
                'z'  => 'ze',
                'c'  => 'ce',
                's'  => 'se',
            ],
            'ai'   => [
                ''   => 'ai',
                'b'  => 'bai',
                'p'  => 'pai',
                'm'  => 'mai',
                'd'  => 'dai',
                't'  => 'tai',
                'n'  => 'nai',
                'l'  => 'lai',
                'g'  => 'gai',
                'k'  => 'kai',
                'h'  => 'hai',
                'zh' => 'zhai',
                'ch' => 'chai',
                'sh' => 'shai',
                'z'  => 'zai',
                'c'  => 'cai',
                's'  => 'sai',
            ],
            'ei'   => [
                ''   => 'ei',
                'b'  => 'bei',
                'p'  => 'pei',
                'm'  => 'mei',
                'f'  => 'fei',
                'd'  => 'dei',
                'n'  => 'nei',
                'l'  => 'lei',
                'g'  => 'gei',
                'k'  => 'kei',
                'h'  => 'hei',
                'zh' => 'zhei',
                'sh' => 'shei',
                'c'  => 'cei',
                's'  => 'sei',
            ],
            'ao'   => [
                ''   => 'ao',
                'b'  => 'bao',
                'p'  => 'pao',
                'm'  => 'mao',
                'd'  => 'dao',
                't'  => 'tao',
                'n'  => 'nao',
                'l'  => 'lao',
                'g'  => 'gao',
                'k'  => 'kao',
                'h'  => 'hao',
                'zh' => 'zhao',
                'ch' => 'chao',
                'sh' => 'shao',
                'r'  => 'rao',
                'z'  => 'zao',
                'c'  => 'cao',
                's'  => 'sao',
            ],
            'ou'   => [
                ''   => 'ou',
                'p'  => 'pou',
                'm'  => 'mou',
                'f'  => 'fou',
                'd'  => 'dou',
                't'  => 'tou',
                'n'  => 'nou',
                'l'  => 'lou',
                'g'  => 'gou',
                'k'  => 'kou',
                'h'  => 'hou',
                'zh' => 'zhou',
                'ch' => 'chou',
                'sh' => 'shou',
                'r'  => 'rou',
                'z'  => 'zou',
                'c'  => 'cou',
                's'  => 'sou',
            ],
            'an'   => [
                ''   => 'an',
                'b'  => 'ban',
                'p'  => 'pan',
                'm'  => 'man',
                'f'  => 'fan',
                'd'  => 'dan',
                't'  => 'tan',
                'n'  => 'nan',
                'l'  => 'lan',
                'g'  => 'gan',
                'k'  => 'kan',
                'h'  => 'han',
                'zh' => 'zhan',
                'ch' => 'chan',
                'sh' => 'shan',
                'r'  => 'ran',
                'z'  => 'zan',
                'c'  => 'can',
                's'  => 'san',
            ],
            'en'   => [
                ''   => 'en',
                'b'  => 'ben',
                'p'  => 'pen',
                'm'  => 'men',
                'f'  => 'fen',
                'd'  => 'den',
                'n'  => 'nen',
                'g'  => 'gen',
                'k'  => 'ken',
                'h'  => 'hen',
                'zh' => 'zhen',
                'ch' => 'chen',
                'sh' => 'shen',
                'r'  => 'ren',
                'z'  => 'zen',
                'c'  => 'cen',
                's'  => 'sen',
            ],
            'ang'  => [
                ''   => 'ang',
                'b'  => 'bang',
                'p'  => 'pang',
                'm'  => 'mang',
                'f'  => 'fang',
                'd'  => 'dang',
                't'  => 'tang',
                'n'  => 'nang',
                'l'  => 'lang',
                'g'  => 'gang',
                'k'  => 'kang',
                'h'  => 'hang',
                'zh' => 'zhang',
                'ch' => 'chang',
                'sh' => 'shang',
                'r'  => 'rang',
                'z'  => 'zang',
                'c'  => 'cang',
                's'  => 'sang',
            ],
            'eng'  => [
                ''   => 'eng',
                'b'  => 'beng',
                'p'  => 'peng',
                'm'  => 'meng',
                'f'  => 'feng',
                'd'  => 'deng',
                't'  => 'teng',
                'n'  => 'neng',
                'l'  => 'leng',
                'g'  => 'geng',
                'k'  => 'keng',
                'h'  => 'heng',
                'zh' => 'zheng',
                'ch' => 'cheng',
                'sh' => 'sheng',
                'r'  => 'reng',
                'z'  => 'zeng',
                'c'  => 'ceng',
                's'  => 'seng',
            ],
            'ong'  => [
                'd'  => 'dong',
                't'  => 'tong',
                'n'  => 'nong',
                'l'  => 'long',
                'g'  => 'gong',
                'k'  => 'kong',
                'h'  => 'hong',
                'zh' => 'zhong',
                'ch' => 'chong',
                'sh' => 'shong',
                'r'  => 'rong',
                'z'  => 'zong',
                'c'  => 'cong',
                's'  => 'song',
            ],
            'er'   => [
                '' => 'er',
            ],
            'ia'   => [
                ''  => 'ya',
                'd' => 'dia',
                'n' => 'nia',
                'l' => 'lia',
                'j' => 'jia',
                'q' => 'qia',
                'x' => 'xia',
            ],
            'ie'   => [
                ''  => 'ye',
                'b' => 'bie',
                'p' => 'pie',
                'm' => 'mie',
                'd' => 'die',
                't' => 'tie',
                'n' => 'nie',
                'l' => 'lie',
                'j' => 'jie',
                'q' => 'qie',
                'x' => 'xie',
            ],
            'iao'  => [
                ''  => 'yao',
                'b' => 'biao',
                'p' => 'piao',
                'm' => 'miao',
                'f' => 'fiao',
                'd' => 'diao',
                't' => 'tiao',
                'n' => 'niao',
                'l' => 'liao',
                'j' => 'jiao',
                'q' => 'qiao',
                'x' => 'xiao',
            ],
            'iu'   => [
                ''  => 'you',
                'm' => 'miu',
                'd' => 'diu',
                'n' => 'niu',
                'l' => 'liu',
                'j' => 'jiu',
                'q' => 'qiu',
                'x' => 'xiu',
            ],
            'ian'  => [
                ''  => 'yan',
                'b' => 'bian',
                'p' => 'pian',
                'm' => 'mian',
                'd' => 'dian',
                't' => 'tian',
                'n' => 'nian',
                'l' => 'lian',
                'j' => 'jian',
                'q' => 'qian',
                'x' => 'xian',
            ],
            'in'   => [
                ''  => 'yin',
                'b' => 'bin',
                'p' => 'pin',
                'm' => 'min',
                'n' => 'nin',
                'l' => 'lin',
                'j' => 'jin',
                'q' => 'qin',
                'x' => 'xin',
            ],
            'ing'  => [
                ''  => 'ying',
                'b' => 'bing',
                'p' => 'ping',
                'm' => 'ming',
                'd' => 'ding',
                't' => 'ting',
                'n' => 'ning',
                'l' => 'ling',
                'j' => 'jing',
                'q' => 'qing',
                'x' => 'xing',
            ],
            'iang' => [
                ''  => 'yang',
                'b' => 'biang',
                'd' => 'diang',
                'n' => 'niang',
                'l' => 'liang',
                'j' => 'jiang',
                'q' => 'qiang',
                'x' => 'xiang',
            ],
            'iong' => [
                ''  => 'yong',
                'j' => 'jiong',
                'q' => 'qiong',
                'x' => 'xiong',
            ],
            'u'    => [
                ''   => 'wu',
                'b'  => 'bu',
                'p'  => 'pu',
                'm'  => 'mu',
                'f'  => 'fu',
                'd'  => 'du',
                't'  => 'tu',
                'n'  => 'nu',
                'l'  => 'lu',
                'g'  => 'gu',
                'k'  => 'ku',
                'h'  => 'hu',
                'zh' => 'zhu',
                'ch' => 'chu',
                'sh' => 'shu',
                'r'  => 'ru',
                'z'  => 'zu',
                'c'  => 'cu',
                's'  => 'su',
            ],
            'ua'   => [
                ''   => 'wa',
                'g'  => 'gua',
                'k'  => 'kua',
                'h'  => 'hua',
                'zh' => 'zhua',
                'ch' => 'chua',
                'sh' => 'shua',
                'r'  => 'rua',
            ],
            'uo'   => [
                ''   => 'wo',
                'd'  => 'duo',
                't'  => 'tuo',
                'n'  => 'nuo',
                'l'  => 'luo',
                'g'  => 'guo',
                'k'  => 'kuo',
                'h'  => 'huo',
                'zh' => 'zhuo',
                'ch' => 'chuo',
                'sh' => 'shuo',
                'r'  => 'ruo',
                'z'  => 'zuo',
                'c'  => 'cuo',
                's'  => 'suo',
            ],
            'uai'  => [
                ''   => 'wai',
                'g'  => 'guai',
                'k'  => 'kuai',
                'h'  => 'huai',
                'zh' => 'zhuai',
                'ch' => 'chuai',
                'sh' => 'shuai',
            ],
            'ui'   => [
                ''   => 'wei',
                'd'  => 'dui',
                't'  => 'tui',
                'g'  => 'gui',
                'k'  => 'kui',
                'h'  => 'hui',
                'zh' => 'zhui',
                'ch' => 'chui',
                'sh' => 'shui',
                'r'  => 'rui',
                'z'  => 'zui',
                'c'  => 'cui',
                's'  => 'sui',
            ],
            'uan'  => [
                ''   => 'wan',
                'd'  => 'duan',
                't'  => 'tuan',
                'n'  => 'nuan',
                'l'  => 'luan',
                'g'  => 'guan',
                'k'  => 'kuan',
                'h'  => 'huan',
                'zh' => 'zhuan',
                'ch' => 'chuan',
                'sh' => 'shuan',
                'r'  => 'ruan',
                'z'  => 'zuan',
                'c'  => 'cuan',
                's'  => 'suan',
            ],
            'un'   => [
                ''   => 'wen',
                'd'  => 'dun',
                't'  => 'tun',
                'n'  => 'nun',
                'l'  => 'lun',
                'g'  => 'gun',
                'k'  => 'kun',
                'h'  => 'hun',
                'zh' => 'zhun',
                'ch' => 'chun',
                'sh' => 'shun',
                'r'  => 'run',
                'z'  => 'zun',
                'c'  => 'cun',
                's'  => 'sun',
            ],
            'uang' => [
                ''   => 'wang',
                'g'  => 'guang',
                'k'  => 'kuang',
                'h'  => 'huang',
                'zh' => 'zhuang',
                'ch' => 'chuang',
                'sh' => 'shuang',
            ],
            'ueng' => [
                '' => 'weng',
            ],
            'ü'    => [
                ''  => 'yu',
                'n' => 'nü',
                'l' => 'lü',
                'j' => 'ju',
                'q' => 'qu',
                'x' => 'xu',
            ],
            'v'    => [
                ''  => 'yu',
                'n' => 'nü',
                'l' => 'lü',
                'j' => 'ju',
                'q' => 'qu',
                'x' => 'xu',
            ],
            'üe'   => [
                ''  => 'yue',
                'n' => 'nüe',
                'l' => 'lüe',
                'j' => 'jue',
                'q' => 'que',
                'x' => 'xue',
            ],
            've'   => [
                ''  => 'yue',
                'n' => 'nüe',
                'l' => 'lüe',
                'j' => 'jue',
                'q' => 'que',
                'x' => 'xue',
            ],
            'üan'  => [
                ''  => 'yuan',
                'l' => 'lüan',
                'j' => 'juan',
                'q' => 'quan',
                'x' => 'xuan',
            ],
            'van'  => [
                ''  => 'yuan',
                'l' => 'lüan',
                'j' => 'juan',
                'q' => 'quan',
                'x' => 'xuan',
            ],
            'ün'   => [
                ''  => 'yun',
                'l' => 'lün',
                'j' => 'jun',
                'q' => 'qun',
                'x' => 'xun',
            ],
            'vn'   => [
                ''  => 'yun',
                'l' => 'lün',
                'j' => 'jun',
                'q' => 'qun',
                'x' => 'xun',
            ],
        ];

        foreach ($table as $final => $initialCombinations) {
            foreach ($initialCombinations as $initial => $expectedSyllable) {
                yield [$initial, $final, $expectedSyllable];
            }
        }
    }
}
